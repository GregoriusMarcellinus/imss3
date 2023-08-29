<?php

namespace App\Http\Controllers;

use App\Models\KodeMaterial;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SheetController extends Controller
{
    public static function getDataSheet(Request $request)
    {
        $type = $request->type;
        if (!$type) return response()->json(['message' => 'Type harus diisi (inka/imss)']);
        // configure the Google Client
        $client = new \Google_Client();
        $guzzle = new Client([
            'verify' => false
        ]);
        $client->setHttpClient($guzzle);
        $client->setApplicationName('Google Sheets API');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('online');
        // credentials.json is the key file we downloaded while setting up our Google Sheets API
        //get to folder public/credentials.json
        $path = public_path('credentials.json');
        $client->setAuthConfig($path);

        // configure the Sheets Service
        $service = new \Google_Service_Sheets($client);
        // https://docs.google.com/spreadsheets/d/11Q3FP6SUGsEKMjON9EfIQ3-cPCUymQauKU7JN1z06E0/edit#gid=1820382864
        // the spreadsheet id can be found in the url https://docs.google.com/spreadsheets/d/143xVs9lPopFSF4eJQWloDYAndMor/edit
        $spreadsheetId = '11Q3FP6SUGsEKMjON9EfIQ3-cPCUymQauKU7JN1z06E0';
        $spreadsheet = $service->spreadsheets->get($spreadsheetId);
        // get all the rows of a sheet
        $range = $type == 'inka' ? 'Komat INKA' : 'Komat IMSS'; // here we use the name of the Sheet to get all the rows
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $rows = $response->getValues();
        array_shift($rows);
        array_shift($rows);
        array_shift($rows);
        $headers = [
            'no',
            'kode_material',
            'nama_barang',
            'spesifikasi',
            'satuan',
        ];
        $arr = [];
        foreach ($rows as $key => $row) {

            $arrayOne = $headers;
            $arrayTwo = $row;

            $result = [];
            $counter = 0;
            array_map(function ($v1, $v2) use (&$result, &$counter) {
                $result[!is_null($v1) ? $v1 : "" . $counter++] = !is_null($v2) ? $v2 : "";
            }, $arrayOne, $arrayTwo);
            $arr[] = $result;
        }

        return response()->json($arr);
    }

    public function sync(Request $request)
    {
        $sheets = self::getDataSheet($request);

        foreach ($sheets->original as $key => $sheet) {
            $product = DB::table('kode_material')->where('kode_material', $sheet['kode_material'])->where('type', $request->type == 'inka' ? 0 : 1)->first();
            if (!$product) {
                $product = new KodeMaterial();
                $product->kode_material = $sheet['kode_material'];
                $product->nama_material = $sheet['nama_barang'];
                $product->spesifikasi = $sheet['spesifikasi'];
                $product->satuan = $sheet['satuan'];
                $product->type = $request->type == 'inka' ? 0 : 1;
                $product->save();
            } else {
                DB::table('products')->where('product_code', $sheet['kode_material'])->update(['product_name' => $sheet['nama_barang'], 'spesifikasi' => $sheet['spesifikasi'], 'satuan' => $sheet['satuan']]);
            }
        }

        return response()->json(['message' => 'Data berhasil disinkronisasi']);
    }

    public function test_komat()
    {
        $komats = KodeMaterial::where('type', 0)->get();

        return response()->json($komats);
    }
}
