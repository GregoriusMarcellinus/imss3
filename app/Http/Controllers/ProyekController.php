<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $items = Proyek::where('nama_proyek', 'LIKE', "%$q%")
            ->paginate(10);

        return view('proyek.index', compact('items'));
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
            'kode_tempat' => 'required',
            'nama_tempat' => 'required',
            'lokasi' => 'required',
            'nama_proyek' => 'required',
            'proyek_mulai' => 'nullable',
            'proyek_selesai' => 'nullable',
            'proyek_status' => 'nullable',
            'trainset_kode' => 'nullable',
            'trainset_nama' => 'nullable',
            'file' => 'required|file|mimes:jpeg,png,pdf',


        ], [
            'kode_tempat.required' => 'Kode Tempat harus diisi',
            'nama_tempat.required' => 'Nama Tempat harus diisi',
            'lokasi.required' => 'Lokasi Masuk harus diisi',
            'nama_proyek.required' => 'Nama Proyek harus diisi',
            'file.required' => 'File harus diisi',


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

        $file = $request->file('file');
        $randomName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        $file->storeAs('photo', $randomName, 'public');

        // $data = $request->all();
        $data = [
            'kode_tempat' => $request->kode_tempat,
            'nama_tempat' => $request->nama_tempat,
            'lokasi' => $request->lokasi,
            'nama_proyek' => $request->nama_proyek,
            'proyek_mulai' => $request->proyek_mulai,
            'proyek_selesai' => $request->proyek_selesai,
            'proyek_status' => $request->proyek_status,
            'trainset_kode' => $request->trainset_kode,
            'trainset_nama' => $request->trainset_nama,
            'file' => $randomName,
        ];

        if (empty($id)) {
            $add = Proyek::create($data);

            if ($add) {
                return redirect()->route('proyek.index')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('proyek.index')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            // $update = Karyawan::where('id', $id)->update($data);

            //     // if ($update) {
            //     //     return redirect()->route('karyawan.index')->with('success', 'Data berhasil diubah');
            //     // } else {
            //     //     return redirect()->route('karyawan.index')->with('error', 'Data gagal diubah');
            //     // }

            $update = Proyek::findOrFail($id);
            $data['kode_tempat'] = $data['kode_tempat'] ? $data['kode_tempat'] : $update->kode_tempat;
            $data['nama_tempat'] = $data['nama_tempat'] ? $data['nama_tempat'] : $update->nama_tempat;
            $data['lokasi'] = $data['lokasi'] ? $data['lokasi'] : $update->lokasi;
            $data['nama_proyek'] = $data['nama_proyek'] ? $data['nama_proyek'] : $update->nama_proyek;
            $data['proyek_mulai'] = $data['proyek_mulai'] ? $data['proyek_mulai'] : $update->proyek_mulai;
            $data['proyek_selesai'] = $data['proyek_selesai'] ? $data['proyek_selesai'] : $update->proyek_selesai;
            $data['proyek_status'] = $data['proyek_status'] ? $data['proyek_status'] : $update->proyek_status;
            $data['trainset_kode'] = $data['trainset_kode'] ? $data['trainset_kode'] : $update->trainset_kode;
            $data['trainset_nama'] = $data['trainset_nama'] ? $data['trainset_nama'] : $update->trainset_nama;
            $data['file'] = $data['file'] ? $data['file'] : $update->file;

            $update->update($data);
        }
        return redirect()->route('proyek.index')->with('success', 'Proyek berhasil diupdate');
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
    public function update(Request $request)
    {
        // $id = $request->id;
        // $kode_tempat = $request->kode_tempat;
        // $nama_tempat = $request->nama_tempat;
        // $lokasi = $request->lokasi;
        // $nama_proyek = $request->nama_proyek;
        // $proyek_mulai = $request->proyek_mulai;
        // $proyek_selesai = $request->proyek_selesai;
        // $proyek_status = $request->proyek_status;
        // $trainset_kode = $request->trainset_kode;
        // $trainset_nama = $request->trainset_nama;

        // $photo = Proyek::where('id', $id)->first();

        // if ($request->file('file')) {
        //     $file = $request->file('file');
        //     $randomName = Str::random(20) . '.' . $file->getClientOriginalExtension();
        //     $file->storeAs('photo', $randomName, 'public');
        // } else {
        //     $randomName = $photo->file;
        // }

        // // dd($randomName);

        // Proyek::where('id', $id)->update([
        //     'kode_tempat' => $kode_tempat,
        //     'file' => $randomName,
        //     'nama_tempat' => $nama_tempat,
        //     'lokasi' => $lokasi,
        //     'nama_proyek' => $nama_proyek,
        //     'proyek_mulai' => $proyek_mulai,
        //     'proyek_selesai' => $proyek_selesai,
        //     'proyek_status' => $proyek_status,
        //     'trainset_kode' => $trainset_kode,
        //     'trainset_nama' => $trainset_nama,
        // ]);


        // return redirect()->route('proyek.index')->with('success', 'File uploaded successfully');
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

        Proyek::where('id', $id)->delete();

        return redirect()->route('proyek.index')->with('success', 'proyek berhasil dihapus');
    }
}
