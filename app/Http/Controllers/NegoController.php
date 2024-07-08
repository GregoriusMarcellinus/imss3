<?php

namespace App\Http\Controllers;

use App\Models\DetailPR;
use App\Models\DetailNego;
use App\Models\Spph;
use App\Models\Keproyekan;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
use App\Models\Nego;
use App\Models\NegoLampiran;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;


class NegoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }
        $negoes = Nego::paginate(50);
        foreach ($negoes as $key => $item) {
            $id = json_decode($item->vendor_id);
            $item->vendor = Vendor::whereIn('id', $id)->get();
            $item->vendor = $item->vendor->map(function ($item) {
                return $item->nama;
            });
            //change $item->vendor collection to array
            $item->vendor = $item->vendor->toArray();
            $item->vendor = implode(', ', $item->vendor);

            //lampiran bisa lebih dari 1
            $lampiran = NegoLampiran::where('nego_id', $item->id)->pluck('file')->toArray();
            $item->lampiran = implode(', ', $lampiran);
            // $item->lampiran = json_decode($item->lampiran); 
        }
        $vendors = Vendor::all();
        // dd($spphes);
        if ($search) {
            $negoes = Nego::where('tanggal_nego', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = Nego::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('nego.nego', compact('negoes', 'vendors'));
        }
    }


    //** */
    public function indexApps(Request $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $negoes = Nego::paginate(50);
        $vendors = Vendor::all();

        if ($search) {
            $negoes = Nego::where('tanggal_nego', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $categories = Nego::where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            return view('home.apps.logistik.nego', compact('negoes', 'vendors'));
        }
    }
    //** */



    //** */
    function FunctionCountPages($path)
    {
        $pdftextfile = file_get_contents($path);
        $pagenumber = preg_match_all("/\/Page\W/", $pdftextfile, $dummy);
        return $pagenumber;
    }
    //** */



    // Simpan dan edit
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $nego = $request->id;
        // if (Session::has('selected_warehouse_id')) {
        //     $warehouse_id = Session::get('selected_warehouse_id');
        // } else {
        //     $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        // }
        // dd($request->all());

        $request->validate([
            'nomor_nego' => 'required',
            'id_pr' => 'required',
            'nomor_pr' => 'required',
            // 'lampiran' => 'required',
            'vendor' => 'required',
            'tanggal_nego' => 'required',
            'batas_nego' => 'required',
            'perihal' => 'required',
            // 'penerima' => 'required',
            // 'alamat' => 'required'
        ], [
            'nomor_nego.required' => 'Nomor Nego harus diisi',
            'id_pr.required' => 'ID pr harus diisi',
            'nomor_pr.required' => 'Nomor pr harus diisi',
            // 'lampiran.required' => 'Lampiran harus diisi',
            'vendor.required' => 'Vendor harus diisi',
            'tanggal_nego.required' => 'Tanggal nego harus diisi',
            'batas_nego.required' => 'Batas nego harus diisi',
            'perihal.required' => 'Perihal harus diisi',
            'penerima.required' => 'Penerima harus diisi',
            'alamat.required' => 'Alamat harus diisi'
        ]);

        $data = [
            'nomor_nego' => $request->nomor_nego,
            'id_pr' => $request->id_pr,
            'nomor_pr' => $request->nomor_pr,
            'vendor_id' => json_encode($request->vendor),
            'tanggal_nego' => $request->tanggal_nego,
            'batas_nego' => $request->batas_nego,
            'perihal' => $request->perihal,
            'penerima' => json_encode($request->penerima),
            'alamat' => json_encode($request->alamat)
        ];

        // Ubah data vendor menjadi ID berdasarkan nama
        $vendorNames = json_decode($data['vendor_id']);
        $vendors = Vendor::whereIn('nama', $vendorNames)->pluck('id')->toArray();
        $data['vendor_id'] = json_encode($vendors);


        // dd($data);

        if (empty($nego)) {
            $add = Nego::create($data);

            // Check if 'lampiran' exists and is not null
            if ($request->hasFile('lampiran')) {
                $files = $request->file('lampiran');
                foreach ($files as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);
                    NegoLampiran::create([
                        'nego_id' => $add->id,
                        'file' => $file_name,
                        'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name))
                    ]);
                }
            }

            if ($add) {
                return redirect()->route('nego.index')->with('success', 'Nego berhasil ditambahkan');
            } else {
                return redirect()->route('nego.index')->with('error', 'Nego gagal ditambahkan');
            }
        } else {
            $update = Nego::where('id', $nego)->update($data);
            if ($request->hasFile('lampiran')) {
                $files = $request->file('lampiran');
                foreach ($files as $file) {
                    $file_name = rand() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('lampiran'), $file_name);
                    NegoLampiran::create([
                        'nego_id' => $nego,
                        'file' => $file_name,
                        'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name))
                    ]);
                }
            }
            // Ambil nama lampiran yang diinginkan dari request
            $nama_lampiran_baru = explode(', ', $request->nama_lampiran); //masih error


            // Ambil semua lampiran yang terkait dengan $spph dari database
            $existing_files = explode(', ', $request->lampiran_awal);

            // dd($nama_lampiran_baru);

            // Loop untuk setiap lampiran yang sudah ada
            foreach ($existing_files as $existing_file) {
                // Jika lampiran tidak termasuk dalam nama lampiran yang baru diupload, hapus dari database dan filesystem
                if (!in_array($existing_file, $nama_lampiran_baru)) {
                    // Hapus dari database
                    NegoLampiran::where('nego_id', $nego)->where('file', $existing_file)->delete();

                    // Hapus dari filesystem jika perlu
                    // $file_path = public_path('lampiran/' . $existing_file);
                    // if (file_exists($file_path)) {
                    //     unlink($file_path);
                    // }
                }
            }

            // if ($request->hasFile('lampiran')) {
            //     $files = $request->file('lampiran');
            //     foreach ($files as $file) {
            //         $file_name = rand() . '.' . $file->getClientOriginalExtension();
            //         $file->move(public_path('lampiran'), $file_name);

            //         // Find the existing SpphLampiran record to update
            //         $lampiran = SpphLampiran::where('spph_id', $spph)->first();

            //         if ($lampiran) {
            //             // Update the existing record
            //             $lampiran->update([
            //                 'file' => $file_name,
            //                 'tipe' => $this->FunctionCountPages(public_path('lampiran/' . $file_name))
            //             ]);
            //         }
            //     }
            // }


            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'SPPH berhasil diupdate',
            //     'data' => $update
            // ]);

            if ($update) {
                return redirect()->route('nego.index')->with('success', 'Nego berhasil diupdate');
            } else {
                return redirect()->route('nego.index')->with('error', 'Nego gagal diupdate');
            }
        }

        // return redirect()->route('spph.index')->with('success', 'SPPH berhasil disimpan');
    }
    
    // End simpan dan edit


    // Hapus
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $delete_nego = $request->id;
        $delete_nego = DB::table('nego')->where('id', $delete_nego)->delete();

        if ($delete_nego) {
            return redirect()->route('nego.index')->with('success', 'Data nego berhasil dihapus');
        } else {
            return redirect()->route('nego.index')->with('error', 'Data nego gagal dihapus');
        }
    }
    // End Hapus



    //Hapus Multiple
    public function hapusMultipleNego(Request $request)
    {
        if ($request->has('ids')) {
            Nego::whereIn('id', $request->input('ids'))->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }
    //End Hapus Multiple


    //Get Detail Nego isian lihat detail
    public function getDetailNego(Request $request)
    {
        $id = $request->id;
        $nego = Nego::where('id', $id)->first();
        $vendor = json_decode($nego->vendor_id);
        $vendor = Vendor::whereIn('id', $vendor)->get();
        $vendor = $vendor->map(function ($item) {
            return $item->nama;
        });
        $vendor = $vendor->toArray();
        $vendor = implode(', ', $vendor);
        $nego->penerima = $vendor;

        $nego->details = DetailNego::where('nego_id', $id)
            ->leftJoin('detail_pr', 'detail_pr.id', '=', 'detail_nego.id_detail_pr')
            ->select('detail_pr.*', 'detail_nego.id as id_detail_nego', 'detail_nego.harga as harga_per_unit')
            ->get();

        $nego->details = $nego->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            // $item->lampiran = $item->lampiran ? $item->lampiran : '';

            // // Start Get lampiran for each detail
            // $lampiran = SpphLampiran::where('spph_id', $item->id)->get();
            // $item->lampiran = $lampiran->map(function ($lampiran) {
            // $item->lampiran = $item->lampiran ? $item->lampiran : '';
            //     // dd($lampiran);
            //     return $lampiran->file; // Assuming `file_name` is the column name
            // })->toArray();
            // //End Get Lampiran for detail

            return $item;
        });

        return response()->json([
            'nego' => $nego
        ]);
    }
    //End Detail Nego


    
    //Detail Product
    public function getProductPR(Request $request)
    {
        // dd($request);
        $id_pr = $request->id_pr; // Ambil id_pr dari request
        $proyek = strtolower($request->proyek);

        // Ambil DetailPR yang sesuai dengan id_pr
        $products = DetailPR::where('id_pr', $id_pr)->get();

        // Proses setiap produk
        $products = $products->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_nego = Nego::where('id', $item->id_nego)->first()->nomor_nego ?? '';
            $item->nomor_spph = Spph::where('id', $item->spph_id)->first()->nomor_spph ?? '';
            $item->pr_no = PurchaseRequest::where('id', $item->id_pr)->first()->no_pr ?? '';
            $item->po_no = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            $item->nama_proyek = Keproyekan::where('id', $item->id_proyek)->first()->nama_proyek ?? '';
            return $item;
        });

        // Filter produk berdasarkan nama proyek
        $products = $products->filter(function ($item) use ($proyek) {
            return strpos(strtolower($item->nama_proyek), $proyek) !== false;
        });

        // Kembalikan hasil dalam bentuk JSON
        return response()->json([
            'products' => $products
        ]);
    }
    //End Detail Product





    //Tambah detail
    function tambahNegoDetail(Request $request)
    {
        $id = $request->nego_id;
        $selected = $request->selected_id;

        if (empty($selected)) {
            return response()->json([
                'success' => FALSE,
                'message' => 'Pilih barang terlebih dahulu'
            ]);
        }

        //foreach selected_id

        foreach ($selected as $key => $value) {
            $detail_pr = DetailPR::find($value);
            $update = DetailPR::where('id', $value)->update([
                'id_nego' => $id,
                'status' => 1,
            ]);
            // $id_barang = $value;
            $add = DetailNego::create([
                'nego_id' => $id,
                'id_detail_pr' => $detail_pr
            ]);

            
        }

        $nego = Nego::where('id', $id)->first();
        // $spph->penerima = json_decode($spph->penerima);
        // $spph->penerima = implode(', ', $spph->penerima);

        $nego->details = DetailNego::where('nego_id', $id)
            ->leftjoin('detail_pr', 'detail_pr.id', '=', 'detail_nego.id_detail_pr')
            ->get();
        $nego->details = $nego->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_nego = Nego::where('id', $item->id_nego)->first()->nomor_nego ?? '';
            return $item;
        });

        return response()->json([
            'success' => TRUE,
            'message' => 'Barang berhasil ditambahkan',
            'nego' => $nego
        ]);
    }
    //End Tambah Detail


    public function nopr()
    {
        $data = PurchaseRequest::where('no_pr', 'LIKE', '%' . request('q') . '%')->paginate(10000);
        return response()->json($data);
    }


    //Print
    public function negoPrint(Request $request)
    {
        $id = $request->spph_id;
        $nego = Nego::where('id', $id)->first();
        $nego->details = DetailNego::where('nego_id', $id)
            ->leftjoin('detail_pr', 'detail_pr.id', '=', 'detail_nego.id_detail_pr')
            ->get();
        $nego->tanggal_nego = Carbon::parse($nego->tanggal_nego)->isoFormat('D MMMM Y');
        $nego->batas_nego = Carbon::parse($nego->batas_nego)->isoFormat('D MMMM Y');

        $vendor = json_decode($nego->vendor_id);
        $vendor_name = Vendor::whereIn('id', $vendor)->get();
        $vendor_name = $vendor_name->map(function ($item) {
            return $item->nama;
        });
        $vendor_name = $vendor_name->toArray();

        $vendor_alamat = Vendor::whereIn('id', $vendor)->get();
        $vendor_alamat = $vendor_alamat->map(function ($item) {
            return $item->alamat;
        });
        $vendor_alamat = $vendor_alamat->toArray();

        $newObjects = [];

        foreach ($vendor_name as $key => $value) {
            $newObject = new \stdClass();
            $newObject->nama = $value;
            $newObject->alamat = $vendor_alamat[$key];
            array_push($newObjects, $newObject);
        }

        $lampiran = NegoLampiran::where('nego_id', $nego->id)->get();
        $nego->lampiran = $lampiran->count();

        $negos = $newObjects;
        $count = count($negos);

        $pdf = PDF::loadview('nego.nego_print', compact('nego', 'negos', 'count', 'lampiran'));
        $no_nego = $nego->nomor_nego;
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream('NEGO_' . $no_nego . '.pdf');
    }
    //EndPrint

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

    
}
