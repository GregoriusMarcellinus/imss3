<?php

namespace App\Http\Controllers;

use App\Models\Trainset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TrainsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $items = Trainset::where('nama_proyek', 'LIKE', "%$q%")
            ->paginate(10);

        // return view('trainset.index', compact('items'));
        
        $items = Trainset::select('trainset.*', 'proyek.nama_proyek as proyek_name','proyek.nama_tempat')
            ->leftjoin('proyek', 'proyek.id', '=', 'trainset.proyek','trainset.nama_tempat')
            ->orderBy('trainset.id', 'asc')
            ->paginate(50);

        $proyeks = DB::table('proyek')->get();
        

            return view('trainset.index', compact('items','proyeks'));
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
            'nama_proyek' => 'nullable',
            'proyek' => 'nullable',
            'trainset_kode' => 'nullable',
            'trainset_nama' => 'nullable',
            'car_nomor' => 'nullable',
            'car_nama' => 'nullable',
            
            


        ], [
            'nama_tempat.required' => 'Nama Tempat harus diisi',
            // 'nama_proyek.required' => 'Nama Proyek harus diisi',
            


        ]);

        
        $data = [
            'nama_tempat' => $request->nama_tempat,
            'nama_proyek' => $request->nama_proyek,
            'proyek' => $request->proyek,
            'trainset_kode' => $request->trainset_kode,
            'trainset_nama' => $request->trainset_nama,
            'car_nomor' => $request->car_nomor,
            'car_nama' => $request->car_nama,
            
            
        ];

        if (empty($id)) {
            $add = Trainset::create($data);

            if ($add) {
                return redirect()->route('trainset.index')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('trainset.index')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            // $update = Karyawan::where('id', $id)->update($data);

            //     // if ($update) {
            //     //     return redirect()->route('karyawan.index')->with('success', 'Data berhasil diubah');
            //     // } else {
            //     //     return redirect()->route('karyawan.index')->with('error', 'Data gagal diubah');
            //     // }

            $update = Trainset::findOrFail($id);
            $data['nama_tempat'] = $data['nama_tempat'] ? $data['nama_tempat'] : $update->nama_tempat;
            $data['nama_proyek'] = $data['nama_proyek'] ? $data['nama_proyek'] : $update->nama_proyek;
            $data['proyek'] = $data['proyek'] ? $data['proyek'] : $update->proyek;
            $data['trainset_kode'] = $data['trainset_kode'] ? $data['trainset_kode'] : $update->trainset_kode;
            $data['trainset_nama'] = $data['trainset_nama'] ? $data['trainset_kode'] : $update->trainset_kode;
            $data['car_nomor'] = $data['car_nomor'] ? $data['car_nomor'] : $update->car_nomor;
            $data['car_nama'] = $data['car_nama'] ? $data['car_nomor'] : $update->car_nomor;
            

            $update->update($data);
        }
        return redirect()->route('trainset.index')->with('success', 'Trainset berhasil diupdate');
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

        Trainset::where('id', $id)->delete();

        return redirect()->route('trainset.index')->with('success', 'trainset berhasil dihapus');
    }
}
