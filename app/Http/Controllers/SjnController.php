<?php

namespace App\Http\Controllers;

use App\Models\Detail_sjn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class SjnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

   
        public function indexApps(Request $req)
        {
            $sort           = $req->sort;
            $search         = $req->q;
            $dl             = $req->dl;
    
            // if (Session::has('selected_warehouse_id')) {
            //     $warehouse_id = Session::get('selected_warehouse_id');
            // } else {
            //     $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
            // }
    
            $sjn = DB::table('sjn')
                ->select("sjn.*");
    
            $sjnExport = $sjn;
    
            
    
            if (!empty($search)) {
                $products = $products->orWhere([["sjn.nama_barang", "LIKE", "%" . $search . "%"], ["sjn.warehouse_id", $warehouse_id]])
                    ->orWhere([["sjn.kode_material", "LIKE", "%" . $search . "%"], ["sjn.warehouse_id", $warehouse_id]]);
            }
    
            if (!empty($sort)) {
                if ($sort == "category_az") {
                    $sjn = $sjn->orderBy("categories.category_name", "asc");
                } else if ($sort == "category_za") {
                    $sjn = $sjn->orderBy("categories.category_name", "desc");
                } else if ($sort == "name_az") {
                    $sjn = $sjn->orderBy("sjn.nama_barang", "asc");
                } else if ($sort == "name_za") {
                    $sjn = $sjn->orderBy("sjn.nama_barang", "desc");
                } else {
                    $sjn = $sjn->orderBy("sjn.product_id", "desc");
                }
            }
    
            $sjn = $sjn->paginate(50);
    
            // $warehouse = $this->getWarehouse();
            
            //     $tmp            = $sjnExport->orderBy("sjn.sjn_id", "asc")->get();
            //     $fn             = 'sjn_' . time();
    
                
    
                $productExport  = [];
    
                // foreach ($tmp as $t) {
                //     $productExport[] = [
                //         "KODE BARANG"         => $t->product_code,
                //         "NAMA BARANG"         => $t->product_name,
                //         "SPESIFIKASI"         => $t->spesifikasi,
                //         "STOK"                => $t->product_amount,
                //         "satuan"              => $t->satuan,
                //         "LOKASI"              => $t->category_name,
    
                //     ];
                // }
    
                if ($dl == "xls") {
                    return (new ProductsExport($productExport))->download($fn . '.xls', \Maatwebsite\Excel\Excel::XLS);
                } else if ($dl == "pdf") {
                    return (new ProductsExport($productExport))->download($fn . '.pdf');
                }
    
            // return View::make("sjn")->with(compact("sjn", "warehouse"));
        
            return view('home.apps.gudang.sjn', compact('sjn'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $sjn = DB::table('sjn')->get();
        // return view('sjnDetail', compact('sjn'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sjn_id = $request->id;
        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }
        $request->validate(
            [
                'no_sjn' => 'required',
            ],
            [
                'no_sjn.required' => 'No. SJN harus diisi',
            ]
        );

        if (empty($sjn_id)) {
            DB::table('sjn')->insert([
                'no_sjn' => $request->no_sjn,
                'warehouse_id' => $warehouse_id,
                "user_id"  => Auth::user()->id,
                "datetime" => Carbon::now()->setTimezone('Asia/Jakarta'),
                'nama_pengirim' => $request->nama_pengirim,
            ]);

            return redirect()->route('sjn')->with('success', 'Data SJN berhasil ditambahkan');
        } else {
            DB::table('sjn')->where('sjn_id', $sjn_id)->update([
                'no_sjn' => $request->no_sjn,
                'warehouse_id' => $warehouse_id,
                "user_id" => Auth::user()->id,
                'nama_pengirim' => $request->nama_pengirim,
            ]);

            return redirect()->route('sjn')->with('success', 'Data SJN berhasil diubah');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        DB::table('sjn')->where('sjn_id', $id)->delete();

        return redirect()->route('sjn')->with('success', 'Data SJN berhasil dihapus');
    }

    public function getDetailSjn(Request $request)
    {
        $id = $request->id;
        $sjn = DB::table('sjn')->where('sjn_id', $id)->first();
        $sjn->products = DB::table('sjn_details')->where('sjn_id', $id)->leftJoin('products', 'products.product_id', '=', 'sjn_details.product_id')->leftJoin('keproyekan', 'keproyekan.id', '=', 'products.keproyekan_id')->select('sjn_details.*', 'products.product_name', 'products.satuan', 'products.product_code', 'products.spesifikasi', 'keproyekan.nama_proyek')->get();
        $sjn->datetime = Carbon::parse($sjn->datetime)->isoFormat('D MMMM Y');

        return response()->json([
            'sjn' => $sjn,
        ]);
    }

    public function updateDetailSjn(Request $request)
    {
        if (!$request->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Qty tidak boleh kosong',
            ]);
        }

        //retrieve json data
        $insert = Detail_sjn::create([
            'sjn_id' => $request->sjn_id,
            'product_id' => $request->product_id,
            'stock' => $request->stock,
        ]);

        if (!$insert) {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal ditambahkan',
            ]);
        }

        $sjn = DB::table('sjn')->where('sjn_id', $request->sjn_id)->first();
        $sjn->products = DB::table('sjn_details')->where('sjn_id', $request->sjn_id)->leftJoin('products', 'products.product_id', '=', 'sjn_details.product_id')->leftJoin('keproyekan', 'keproyekan.id', '=', 'products.keproyekan_id')->select('sjn_details.*', 'products.product_name', 'products.satuan', 'products.product_code', 'products.spesifikasi', 'keproyekan.nama_proyek')->get();
        $sjn->datetime = Carbon::parse($sjn->datetime)->isoFormat('D MMMM Y');

        return response()->json([
            'success' => true,
            'sjn' => $sjn,
        ]);
    }

    public function cetakSjn(Request $request)
    {
        $id = $request->sjn_id;
        $sjn = DB::table('sjn')->where('sjn_id', $id)->first();
        $sjn->products = DB::table('sjn_details')->where('sjn_id', $id)->leftJoin('products', 'products.product_id', '=', 'sjn_details.product_id')->leftJoin('keproyekan', 'keproyekan.id', '=', 'products.keproyekan_id')->select('sjn_details.*', 'products.product_name', 'products.satuan', 'products.product_code', 'products.spesifikasi', 'keproyekan.nama_proyek')->get();
        $sjn->datetime = Carbon::parse($sjn->datetime)->isoFormat('D MMMM Y');

        // return view('sjn_print', compact('sjn'));
        $pdf = PDF::loadview('sjn.sjn_print', compact('sjn'));
        $no_sjn = $sjn->no_sjn;
        //stream with no_sjn title
        return $pdf->stream('SJN-' . $no_sjn . '.pdf');
    }
}
