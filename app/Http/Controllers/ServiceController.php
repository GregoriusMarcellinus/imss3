<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\Detailservice;
use App\Models\Jadwal;
use App\Models\Proyek;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        //     $items = Service::select('service.*', 'jadwal.kode_perawatan','proyek.nama_tempat','proyek.nama_proyek')
        //     ->leftjoin('jadwal', 'jadwal.id', '=', 'service.perawatan')
        //     ->leftjoin('proyek', 'proyek.id', '=', 'service.nama_tempat','service.nama_proyek')
        //     ->orderBy('service.id', 'asc')
        //     ->paginate(50);

        // $proyeks = DB::table('jadwal')->get();
        // $tempats = DB::table('proyek')->get();


        $proyeks = Jadwal::all();
        $tempats = Proyek::all();

        $details = Detailservice::where('id_service', $request->id)->get();

        return view('service.index', compact('items', 'proyeks', 'tempats', 'details'));
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
            'nama_proyek' => 'nullable',
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




        ]);


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


    public function getDetailService(Request $request)
    {
        $id = $request->id;
        $service = Service::where('id', $id)->first();

        $service->details = Detailservice::where('id_service', $id)->get();
        // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
        $service->details = $service->details->map(function ($item) {
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nama_barang = $item->nama_barang ? $item->nama_barang : '';
            $item->spesifikasi = $item->spesifikasi ? $item->spesifikasi : '';
            return $item;
        });
        return response()->json([
            'service' => $service
        ]);
    }

    public function delete($id) {
        try {
            $service = Detailservice::findOrFail($id);
            $service->delete();
            return response()->json(['message' => 'Produk berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus produk'], 500);
        }
    }

   
    public function updateDetailService(Request $request)
    {
        // if (!$request->stock) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'QTY tidak boleh kosong'
        //     ]);
        // }
        // $request->validate([
        //     'lampiran' => 'nullable|file|mimes:pdf|max:500',
        // ]);



        $insert = Detailservice::create([
            'id_service' => $request->id_service,
            'kode_material' => $request->kode_material,
            'nama_barang' => $request->nama_barang,
            'spesifikasi' => $request->spesifikasi,

        ]);

        if (!$insert) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan detail PR'
            ]);
        }

        $service = DB::table('service')->where('id', $request->id_service)->first();
        $service->details = Detailservice::where('id_service', $request->id_service)->get();
        $service->details = $service->details->map(function ($item) {
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nama_barang = $item->nama_barang ? $item->nama_barang : '';
            $item->spesifikasi = $item->spesifikasi ? $item->spesifikasi : '';
            // $item->kode_material = $item->kode_material ? $item->kode_material : '';
            // $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            // $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            // $item->lampiran = $item->lampiran ? $item->lampiran : '';
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan detail PR',
            'service' => $service
        ]);
    }




    public function destroy(Request $request)
    {
        $id = $request->delete_id;

        Service::where('id', $id)->delete();

        return redirect()->route('service.index')->with('success', 'service berhasil dihapus');
    }

    public function detailServiceSave(Request $request)
    {
        $id_service = $request->id;
        $id = $request->id_service;
        $kode_material = $request->kode_material;
        $nama_barang = $request->nama_barang;
        $spesifikasi = $request->spesifikasi;
        // $no_just = $request->no_just;
        // $tanggal_just = $request->tanggal_just;
        // $no_nego1 = $request->no_nego1;
        // $tanggal_nego1 = $request->tanggal_nego1;
        // $batas_nego1 = $request->batas_nego1;
        // $no_nego2 = $request->no_nego2;
        // $tanggal_nego2 = $request->tanggal_nego2;
        // $batas_nego2 = $request->batas_nego2;

        Detailservice::where('id', $id_service)->update([
            'kode_material' => $kode_material,
            'nama_barang' => $nama_barang,
            'spesifikasi' => $spesifikasi,
            // 'no_just' => $no_just,
            // 'tanggal_just' => $tanggal_just,
            // 'no_nego1' => $no_nego1,
            // 'tanggal_nego1' => $tanggal_nego1,
            // 'batas_nego1' => $batas_nego1,
            // 'no_nego2' => $no_nego2,
            // 'tanggal_nego2' => $tanggal_nego2,
            // 'batas_nego2' => $batas_nego2,
        ]);

        $service = Service::where('id', $id)->first();
        $service->details = Detailservice::where('id_service', $service->id)->get();
        // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
        $service->details = $service->details->map(function ($item) {
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nama_barang = $item->nama_barang ? $item->nama_barang : '';
            $item->spesifikasi = $item->spesifikasi ? $item->spesifikasi : '';
            // $item->kode_material = $item->kode_material ? $item->kode_material : '';
            // $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            // $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';

            // $item->no_sph = $item->no_sph ?? '';
            // $item->tanggal_sph = $item->tanggal_sph ?? '';
            // $item->no_just = $item->no_just ?? '';
            // $item->tanggal_just = $item->tanggal_just ?? '';
            // $item->no_nego1 = $item->no_nego1 ?? '';
            // $item->tanggal_nego1 = $item->tanggal_nego1 ?? '';
            // $item->batas_nego1 = $item->batas_nego1 ?? '';
            // $item->no_nego2 = $item->no_nego2 ?? '';
            // $item->tanggal_nego2 = $item->tanggal_nego2 ?? '';
            // $item->batas_nego2 = $item->batas_nego2 ?? '';
            return $item;
        });
        return response()->json([
            'service' => $service
        ]);
    }
}
