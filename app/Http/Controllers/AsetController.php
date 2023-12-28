<?php

namespace App\Http\Controllers;

use App\Imports\AsetImport;
use App\Models\Aset;
use App\Models\KodeAset;
use App\Models\PenghapusanAset;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tipe = $request->type;
        $items = Aset::leftjoin('kode_aset', 'kode_aset.id', '=', 'asets.aset_id')
            ->select('asets.*', 'kode_aset.kode', 'kode_aset.keterangan')
            ->where('asets.tipe', $request->type)
            ->paginate(10);
        $kode_asets = KodeAset::all();
        if ($tipe == 1) {
            $title = "Aset";
        } else {
            $title = "Inventaris";
        }

        return view('aset_inventaris.aset.index', compact('items', 'title', 'kode_asets', 'tipe'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $tipe = $request->tipe;

        $request->validate([
            'aset_id' => 'required',
            'jenis_aset' => 'required',
            'merek' => 'nullable',
            'no_seri' => 'nullable',
            'kondisi' => 'required',
            'lokasi' => 'required',
            'pengguna' => 'nullable',
            'tanggal_perolehan' => 'required|date',
            'keterangan' => 'nullable',
        ]);

        $data = $request->all();

        if ($id == null) {
            $this_year = date('Y', strtotime($request->tanggal_perolehan));
            $count = Aset::where('aset_id', $request->aset_id)->where('tipe', $tipe);
            // dd($count->count(), $request->aset_id, $tipe);
            if ($count->count() == 0) {
                $count = 1;
            } else {
                //get the last id then add 1
                $count = $count->latest()->first()->nomor_aset;
                $count = explode('/', $count)[0];
                $count = $count + 1;
            }

            //add 00 in count example 001, 002 with str_pad
            $count = str_pad($count, 3, '0', STR_PAD_LEFT);

            $kode_aset = KodeAset::where('id', $request->aset_id)->first();
            $data['nomor_aset'] = $count . '/' . $kode_aset->kode . '/UMUM/' . $this_year;
            Aset::create($data);
            return redirect()->back()->with('success', 'Aset/inventaris berhasil ditambahkan');
        } else {
            $update = Aset::findOrFail($id);
            $data['aset_id'] = $data['aset_id'] ? $data['aset_id'] : $update->aset_id;
            $data['tipe'] = $data['tipe'] ? $data['tipe'] : $update->tipe;
            $data['nomor_aset'] = $update->nomor_aset;
            $data['jenis_aset'] = $data['jenis_aset'] ? $data['jenis_aset'] : $update->jenis_aset;
            $data['merek'] = $data['merek'] ? $data['merek'] : $update->merek;
            $data['no_seri'] = $data['no_seri'] ? $data['no_seri'] : $update->no_seri;
            $data['kondisi'] = $data['kondisi'] ? $data['kondisi'] : $update->kondisi;
            $data['lokasi'] = $data['lokasi'] ? $data['lokasi'] : $update->lokasi;
            $data['pengguna'] = $data['pengguna'] ? $data['pengguna'] : $update->pengguna;
            $data['tanggal_perolehan'] = $data['tanggal_perolehan'] ? $data['tanggal_perolehan'] : $update->tanggal_perolehan;
            $data['keterangan'] = $data['keterangan'] ? $data['keterangan'] : $update->keterangan;
            $update->update($data);
            return redirect()->back()->with('success', 'Aset/inventaris berhasil diupdate');
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

    public function import(Request $request)
    {

        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('file');

        $nama_file = rand() . $file->getClientOriginalName();

        $file->move(public_path('temp'), $nama_file);

        // $file = public_path('karyawan.xlsx');
        Excel::import(new AsetImport,public_path('temp/' . $nama_file));

        return redirect()->back()->with('success','berhasil di import');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->delete_id;
        $tipe = $request->type;

        $aset = Aset::where('id', $id)->first();

        //insert penghapusan aset
        PenghapusanAset::create([
            'kode_aset_id' => $aset->id,
            'tipe' => $aset->tipe,
            'nomor_aset' => $aset->nomor_aset,
            'jenis_aset' => $aset->jenis_aset,
            'merek' => $aset->merek,
            'no_seri' => $aset->no_seri,
            'kondisi' => $aset->kondisi,
            'lokasi' => $aset->lokasi,
            'pengguna' => $aset->pengguna,
            'tanggal_perolehan' => $aset->tanggal_perolehan,
            'keterangan' => $aset->keterangan,
        ]);

        Aset::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Aset/inventaris berhasil dihapus');
    }

    //import function

    // export function
}
