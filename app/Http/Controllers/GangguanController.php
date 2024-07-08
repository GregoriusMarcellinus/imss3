<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use App\Models\Jadwal;
use App\Models\Proyek;
use Illuminate\Http\Request;

class GangguanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $items = Gangguan::where('nama_tempat', 'LIKE', "%$q%")
            ->paginate(10);

            

        //     $items = Service::select('service.*', 'jadwal.kode_perawatan','proyek.nama_tempat','proyek.nama_proyek')
        //     ->leftjoin('jadwal', 'jadwal.id', '=', 'service.perawatan')
        //     ->leftjoin('proyek', 'proyek.id', '=', 'service.nama_tempat','service.nama_proyek')
        //     ->orderBy('service.id', 'asc')
        //     ->paginate(50);

        // $proyeks = DB::table('jadwal')->get();
        // $tempats = DB::table('proyek')->get();

        $proyeks = Jadwal::all();
        $tempats = Proyek::all();

        // $details = Detailservice::where('id_service', $request->id)->get();

        return view('gangguan.index', compact('items', 'proyeks', 'tempats'));
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

        // dd($request->all());
        $request->validate([
            'nama_tempat' => 'required',
            'lokasi' => 'required',
            'perkiraan_mulai' => 'nullable',
            'perkiraan_selesai' => 'nullable',
            'kondisi' => 'nullable',
            'nama_proyek' => 'nullable',
            'trainset' => 'nullable',
            'car' => 'nullable',
            'perawatan' => 'nullable',
            'tanggal_gangguan' => 'nullable',
            'perkiraan_gangguan' => 'nullable',
            'penyebab_gangguan' => 'nullable',
            'jenis_gangguan' => 'nullable',
            'nama_barang' => 'nullable',
            'jumlah' => 'nullable',
            'satuan' => 'nullable',
            'tindak_lanjut' => 'nullable',
            'hasil_tindak_lanjut' => 'nullable',
            'pelapor' => 'nullable',
            'status' => 'nullable',
            'keterangan' => 'nullable',



        ], [
            'nama_tempat.required' => 'Nama Tempat harus diisi',
            'lokasi.required' => 'Lokasi Masuk harus diisi',




        ]);


        $data = [
            'nama_tempat' => $request->nama_tempat,
            'lokasi' => $request->lokasi,
            'perkiraan_mulai' => $request->perkiraan_mulai,
            'perkiraan_selesai' => $request->perkiraan_selesai,
            'kondisi' => $request->kondisi,
            'nama_proyek' => $request->nama_proyek,
            'trainset' => $request->trainset,
            'car' => $request->car,
            'perawatan' => $request->perawatan,
            'tanggal_gangguan' => $request->tanggal_gangguan,
            'perkiraan_gangguan' => $request->perkiraan_gangguan,
            'penyebab_gangguan' => $request->penyebab_gangguan,
            'jenis_gangguan' => $request->jenis_gangguan,
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'tindak_lanjut' => $request->tindak_lanjut,
            'hasil_tindak_lanjut' => $request->hasil_tindak_lanjut,
            'pelapor' => $request->pelapor,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
            // 'file' => $randomName,
        ];

        if (empty($id)) {
            $add = Gangguan::create($data);

            if ($add) {
                return redirect()->route('gangguan.index')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('gangguan.index')->with('error', 'Data gagal ditambahkan');
            }
        } else {
            // $update = Karyawan::where('id', $id)->update($data);

            //     // if ($update) {
            //     //     return redirect()->route('karyawan.index')->with('success', 'Data berhasil diubah');
            //     // } else {
            //     //     return redirect()->route('karyawan.index')->with('error', 'Data gagal diubah');
            //     // }

            $update = Gangguan::findOrFail($id);
            $data['nama_tempat'] = $data['nama_tempat'] ? $data['nama_tempat'] : $update->nama_tempat;
            $data['lokasi'] = $data['lokasi'] ? $data['lokasi'] : $update->lokasi;
            $data['perkiraan_mulai'] = $data['perkiraan_mulai'] ? $data['perkiraan_mulai'] : $update->perkiraan_mulai;
            $data['perkiraan_selesai'] = $data['perkiraan_selesai'] ? $data['perkiraan_selesai'] : $update->perkiraan_selesai;
            $data['kondisi'] = $data['kondisi'] ? $data['kondisi'] : $update->kondisi;
            $data['nama_proyek'] = $data['nama_proyek'] ? $data['nama_proyek'] : $update->nama_proyek;
            $data['trainset'] = $data['trainset'] ? $data['trainset'] : $update->trainset;
            $data['car'] = $data['car'] ? $data['car'] : $update->car;
            $data['perawatan'] = $data['perawatan'] ? $data['perawatan'] : $update->perawatan;
            $data['tanggal_gangguan'] = $data['tanggal_gangguan'] ? $data['tanggal_gangguan'] : $update->tanggal_gangguan;
            $data['perkiraan_gangguan'] = $data['perkiraan_gangguan'] ? $data['perkiraan_gangguan'] : $update->perkiraan_gangguan;
            $data['penyebab_gangguan'] = $data['penyebab_gangguan'] ? $data['penyebab_gangguan'] : $update->penyebab_gangguan;
            $data['jenis_gangguan'] = $data['jenis_gangguan'] ? $data['jenis_gangguan'] : $update->jenis_gangguan;
            $data['nama_barang'] = $data['nama_barang'] ? $data['nama_barang'] : $update->nama_barang;
            $data['jumlah'] = $data['jumlah'] ? $data['jumlah'] : $update->jumlah;
            $data['satuan'] = $data['satuan'] ? $data['satuan'] : $update->satuan;
            $data['tindak_lanjut'] = $data['tindak_lanjut'] ? $data['tindak_lanjut'] : $update->tindak_lanjut;
            $data['hasil_tindak_lanjut'] = $data['hasil_tindak_lanjut'] ? $data['hasil_tindak_lanjut'] : $update->hasil_tindak_lanjut;
            $data['pelapor'] = $data['pelapor'] ? $data['pelapor'] : $update->pelapor;
            $data['status'] = $data['status'] ? $data['status'] : $update->status;
            $data['keterangan'] = $data['keterangan'] ? $data['keterangan'] : $update->keterangan;

            $update->update($data);
            return redirect()->route('gangguan.index')->with('success', 'Data Gangguan berhasil diupdate');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getDetailGangguan(Request $request)
    {
        $id = $request->id;
        $gangguan = Gangguan::where('id', $id)->first();

        $gangguan->details = Gangguan::where('id', $id)->get();
        // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
        $gangguan->details = $gangguan->details->map(function ($item) {
            $item->tanggal_gangguan = $item->tanggal_gangguan ? $item->tanggal_gangguan : '';
            $item->perkiraan_gangguan = $item->perkiraan_gangguan ? $item->perkiraan_gangguan : '';
            $item->penyebab_gangguan = $item->penyebab_gangguan ? $item->penyebab_gangguan : '';
            $item->jenis_gangguan = $item->jenis_gangguan ? $item->jenis_gangguan : '';
            $item->tindak_lanjut = $item->tindak_lanjut ? $item->tindak_lanjut : '';
            $item->hasil_tindak_lanjut = $item->hasil_tindak_lanjut ? $item->hasil_tindak_lanjut : '';
            $item->nama_barang = $item->nama_barang ? $item->nama_barang : '';
            $item->jumlah = $item->jumlah ? $item->jumlah : '';
            $item->satuan = $item->satuan ? $item->satuan : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            return $item;
        });
        return response()->json([
            'gangguan' => $gangguan
        ]);
    }


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

        Gangguan::where('id', $id)->delete();

        return redirect()->route('gangguan.index')->with('success', 'Data gangguan berhasil dihapus');
    }
}
