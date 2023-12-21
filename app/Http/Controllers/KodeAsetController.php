<?php

namespace App\Http\Controllers;

use App\Models\KodeAset;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class KodeAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = KodeAset::paginate(10);

        return view('aset_inventaris.kode_aset.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $kode = $request->kode_aset_id;
        $request->validate([
            'kode' => 'required',
            'keterangan' => 'required',
        ]);

        $data = $request->all();
        $data['id_user'] = auth()->user()->id;

        if ($kode == null) {
            KodeAset::create($data);
            return redirect()->route('kode_aset.index')->with('success', 'Kode Aset berhasil ditambahkan');
        } else {
            $update = KodeAset::findOrFail($kode);
            $data['kode'] = $data['kode'] ? $data['kode'] : $update->kode;
            $data['keterangan'] = $data['keterangan'] ? $data['keterangan'] : $update->keterangan;
            $update->update($data);
            return redirect()->route('kode_aset.index')->with('success', 'Kode Aset berhasil diupdate');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
