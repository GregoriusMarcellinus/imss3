<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $items = Service::where('nama_proyek', 'LIKE', "%$q%")
            ->paginate(10);

        return view('service.index', compact('items'));
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
            'nama_tempat' => 'required',
            'lokasi' => 'required',
            'nama_proyek' => 'required',
            'trainset' => 'nullable',
            'car' => 'nullable',
            'perawatan' => 'nullable',
            'perawatan_mulai' => 'nullable',
            'perawatan_selesai' => 'nullable',
            'komponen_diganti' => 'nullable',
            'tanggal_komponen' => 'nullable',
            'pic' => 'nullable',
            'keterangan' => 'nullable',
            


        ], [
            'nama_tempat.required' => 'Nama Tempat harus diisi',
            'lokasi.required' => 'Lokasi Masuk harus diisi',
            'nama_proyek.required' => 'Nama Proyek harus diisi',
            


        ]);

        // $file = $request->file('file');
        // $randomName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        // $file->storeAs('photo', $randomName, 'public');

        // $upload = new Proyek([
        //     'kode_tempat' => $request->input('kode_tempat'),
        //     'file' => $randomName,
        //     'nama_tempat' => $request->input('nama_tempat'),
        //     'lokasi' => $request->input('lokasi'),
        //     'nama_proyek' => $request->input('nama_proyek'),
        //     'proyek_mulai' => $request->input('proyek_mulai'),
        //     'proyek_selesai' => $request->input('proyek_selesai'),
        //     'proyek_status' => $request->input('proyek_status'),
        //     'trainset_kode' => $request->input('trainset_kode'),
        //     'trainset_nama' => $request->input('trainset_nama'),
        // ]);
        // $upload->save();

        // $file = $request->file('file');
        // $randomName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        // $file->storeAs('photo', $randomName, 'public');

        // $data = $request->all();
        $data = [
            'nama_tempat' => $request->nama_tempat,
            'lokasi' => $request->lokasi,
            'nama_proyek' => $request->nama_proyek,
            'trainset' => $request->trainset,
            'car' => $request->car,
            'perawatan' => $request->perawatan,
            'perawatan_mulai' => $request->perawatan_mulai,
            'perawatan_selesai' => $request->perawatan_selesai,
            'komponen_diganti' => $request->komponen_diganti,
            'tanggal_komponen' => $request->tanggal_komponen,
            'pic' => $request->pic,
            'keterangan' => $request->keterangan,
            // 'file' => $randomName,
        ];

        if (empty($id)) {
            $add = Service::create($data);

            if ($add) {
                return redirect()->route('service.index')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('service.index')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            // $update = Karyawan::where('id', $id)->update($data);

            //     // if ($update) {
            //     //     return redirect()->route('karyawan.index')->with('success', 'Data berhasil diubah');
            //     // } else {
            //     //     return redirect()->route('karyawan.index')->with('error', 'Data gagal diubah');
            //     // }

            $update = Service::findOrFail($id);
            $data['nama_tempat'] = $data['nama_tempat'] ? $data['nama_tempat'] : $update->nama_tempat;
            $data['lokasi'] = $data['lokasi'] ? $data['lokasi'] : $update->lokasi;
            $data['nama_proyek'] = $data['nama_proyek'] ? $data['nama_proyek'] : $update->nama_proyek;
            $data['trainset'] = $data['trainset'] ? $data['trainset'] : $update->trainset;
            $data['car'] = $data['car'] ? $data['car'] : $update->car;
            $data['perawatan'] = $data['perawatan'] ? $data['perawatan'] : $update->perawatan;
            $data['perawatan_mulai'] = $data['perawatan_mulai'] ? $data['perawatan_mulai'] : $update->perawatan_mulai;
            $data['perawatan_selesai'] = $data['perawatan_selesai'] ? $data['perawatan_selesai'] : $update->perawatan_selesai;
            $data['komponen_diganti'] = $data['komponen_diganti'] ? $data['komponen_diganti'] : $update->komponen_diganti;
            $data['tanggal_komponen'] = $data['tanggal_komponen'] ? $data['tanggal_komponen'] : $update->tanggal_komponen;
            $data['pic'] = $data['pic'] ? $data['pic'] : $update->pic;
            $data['keterangan'] = $data['keterangan'] ? $data['keterangan'] : $update->keterangan;

            $update->update($data);
        }
        return redirect()->route('service.index')->with('success', 'Proyek berhasil diupdate');
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

        Service::where('id', $id)->delete();

        return redirect()->route('service.index')->with('success', 'service berhasil dihapus');
    }
}
