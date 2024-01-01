<?php

namespace App\Http\Controllers;

use App\Exports\KaryawanExport;
use App\Imports\KaryawanImport;
use App\Models\Karyawan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $items = Karyawan::where('nama', 'LIKE', "%$q%")
        ->paginate(10);

        foreach ($items as $item) {
           
            // Convert the tanggal_masuk to a Carbon instance
            $tanggalMasuk = Carbon::parse($item->tanggal_masuk);
        
            // Calculate the difference in years and months
            $difference = $tanggalMasuk->diff(Carbon::now());
            $lamaBekerjaTahun = $difference->y;
            $lamaBekerjaBulan = $difference->m;

            //usia
            $tanggalLahir = Carbon::parse($item->tanggal_lahir);
        
            // Calculate the difference in years and months
            $differenceLahir = $tanggalLahir->diff(Carbon::now());
            $usiaTahun = $differenceLahir->y;
            $usiaBulan = $differenceLahir->m;
            $usia = "$usiaTahun tahun $usiaBulan bulan";
        
            // Add the calculated values to the item
            $item->tanggal_masuk = Carbon::parse($item->tanggal_masuk)->isoFormat('D MMMM Y');
            $item->tanggal_pengangkatan_atau_akhir_kontrak = Carbon::parse($item->tanggal_pengangkatan_atau_akhir_kontrak)->isoFormat('D MMMM Y');
            $item->tanggal_lahir = Carbon::parse($item->tanggal_lahir)->isoFormat('D MMMM Y');

            //jika item berbeda menggunakan tanda tanya(?) lalu titik dua (:) trus else / isi nya
            $item->pensiun =  $item->pensiun ? Carbon::parse($item->pensiun)->isoFormat('D MMMM Y') : "";

            $item->lama_bekerja_tahun = $lamaBekerjaTahun;
            $item->lama_bekerja_bulan = $lamaBekerjaBulan;
            $item->usia = $usia;
        }
        return view('karyawan.index', compact('items'));
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
            'nip' => 'required',
            'nama' => 'required',
            'tanggal_masuk' => 'required',
            'status_pegawai' => 'nullable',

        ], [
            'nip.required' => 'NIP harus diisi',
            'nama.required' => 'Nama harus diisi',
            'tanggal_masuk.required' => 'Tanggal Masuk harus diisi',
            // 'status_pegawai.required' => 'Status Pegawai harus diisi',
            
        ]);

        $data = $request->all();

        if (empty($id)) {
            $add = Karyawan::create($data);

            if ($add) {
                return redirect()->route('karyawan.index')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('karyawan.index')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            $update = Karyawan::where('id', $id)->update($data);

            if ($update) {
                return redirect()->route('karyawan.index')->with('success', 'Data berhasil diubah');
            } else {
                return redirect()->route('karyawan.index')->with('error', 'Data gagal diubah');
            }
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
        $id = $request->delete_id;

        Karyawan::where('id', $id)->delete();

        return redirect()->route('karyawan.index')->with('success', 'karyawan berhasil dihapus');
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
        Excel::import(new KaryawanImport, public_path('temp/' . $nama_file));

        return redirect()->back()->with('success', 'berhasil di import');
    }
    public function export()
    {
        $nama_file = rand() . '.xlsx';
        return Excel::download(new KaryawanExport, $nama_file);
    }
}
