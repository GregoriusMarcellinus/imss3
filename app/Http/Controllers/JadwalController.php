<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $items = Jadwal::where('kode_perawatan', 'LIKE', "%$q%")
            ->paginate(10);

        return view('jadwal.index', compact('items'));
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
        $request->validate([
            'kode_perawatan' => 'required',
            'nama_perawatan' => 'nullable',
            'periode_hari' => 'nullable',
            'catatan' => 'nullable',



        ], [
            'kode_perawatan.required' => 'Nama Tempat harus diisi',
            // 'nama_proyek.required' => 'Nama Proyek harus diisi',



        ]);


        $data = [
            'kode_perawatan' => $request->kode_perawatan,
            'nama_perawatan' => $request->nama_perawatan,
            'periode_hari' => $request->periode_hari,
            'catatan' => $request->catatan,



        ];

        if (empty($id)) {
            $add = Jadwal::create($data);

            if ($add) {
                return redirect()->route('jadwal.index')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('jadwal.index')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            // $update = Karyawan::where('id', $id)->update($data);

            //     // if ($update) {
            //     //     return redirect()->route('karyawan.index')->with('success', 'Data berhasil diubah');
            //     // } else {
            //     //     return redirect()->route('karyawan.index')->with('error', 'Data gagal diubah');
            //     // }

            $update = Jadwal::findOrFail($id);
            $data['kode_perawatan'] = $data['kode_perawatan'] ? $data['kode_perawatan'] : $update->kode_perawatan;
            $data['nama_perawatan'] = $data['nama_perawatan'] ? $data['nama_perawatan'] : $update->nama_perawatan;
            $data['periode_hari'] = $data['periode_hari'] ? $data['periode_hari'] : $update->periode_hari;
            $data['catatan'] = $data['catatan'] ? $data['catatan'] : $update->catatan;



            $update->update($data);
        }
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate');
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
        $id = $request->delete_id;

        Jadwal::where('id', $id)->delete();

        return redirect()->route('jadwal.index')->with('success', 'jadwal berhasil dihapus');
    }
}
