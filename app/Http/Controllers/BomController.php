<?php

namespace App\Http\Controllers;

use App\Models\Bom;
use App\Models\DetailPo;
use App\Models\DetailPR;
use App\Models\DetailSpph;
use App\Models\Keproyekan;
use App\Models\Lppb;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
use App\Models\RegistrasiBarang;
use App\Models\Spph;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;

class BomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $requests = Bom::select('bom.*', 'proyek.nama_proyek as proyek_name')
            ->leftjoin('proyek', 'proyek.id', '=', 'bom.proyek')
            ->orderBy('bom.id', 'asc')
            ->paginate(50);

        $proyeks = DB::table('proyek')->get();
        //  dd($requests);

        if ($search) {
            $requests = Bom::where('kode_material', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $requests = Bom::where("warehouse_id", $warehouse_id)->get();

            return response()->json($requests);
        } else {

            //looping the paginate
            foreach ($requests as $request) {
                $detail_pr = Bom::where('id', $request->id)->get();
                //if detail_pr empty then editable true
                if ($detail_pr->isEmpty()) {
                    $request->editable = TRUE;
                } else {
                    //looping detail_pr then check in detailspph with id_detail_pr exist
                    foreach ($detail_pr as $detail) {
                        $detail_spph = DetailSpph::where('id_detail_pr', $detail->id)->first();
                        $po = Purchase_Order::where('id', $detail->id_po)->first();
                        if ($po && $po->tipe == '1') {
                            $request->editable = FALSE;
                            break;
                        } else {
                            if ($detail_spph) {
                                $request->editable = FALSE;
                                break;
                            } else {
                                $request->editable = TRUE;
                            }
                        }
                    }
                }
            }
            return view('bom.index', compact('requests', 'proyeks'));
        }
    }
    
    public function indexApps(Request $request)
    {
        $search = $request->q;

        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $requests = Bom::select('bom.*', 'proyek.nama_proyek as proyek_name')
            ->join('proyek', 'proyek.id', '=', 'bom.proyek_id')
            ->paginate(50);

        $proyeks = DB::table('proyek')->get();

        if ($search) {
            $requests = Bom::where('nama_proyek', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $requests = Bom::where("warehouse_id", $warehouse_id)->get();

            return response()->json($requests);
        } else {
            return view('bom.index', compact('requests', 'proyeks'));
        }
    }



    public function getDetailBom(Request $request)
    {
        $id = $request->id;
        $pr = Bom::select('bom.*', 'proyek.nama_proyek as nama_proyek')
            ->leftjoin('proyek', 'proyek.id', '=', 'bom.proyek_id')
            ->where('bom.id', $id)
            ->first();
        $pr->details = Bom::where('id', $id)->get();
        // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
        $pr->details = $pr->details->map(function ($item) {
            $item->nomor = $item->nomor ? $item->nomor : '';
            $item->tanggal = $item->tanggal ? $item->tanggal : '';
            $item->proyek = $item->proyek ? $item->proyek : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->deskripsi_material = $item->deskripsi_material ? $item->deskripsi_material : '';
            $item->spesifikasi = $item->spesifikasi ? $item->spesifikasi : '';
            $item->p1 = $item->p1 ? $item->p1 : '';
            $item->p3 = $item->p3 ? $item->p3 : '';
            $item->p6 = $item->p6 ? $item->p6 : '';
            $item->p12 = $item->p6 ? $item->p6 : '';
            $item->p24 = $item->p24 ? $item->p24 : '';
            $item->p36 = $item->p36 ? $item->p36 : '';
            $item->p48 = $item->p48 ? $item->p48 : '';
            $item->p60 = $item->p60 ? $item->p60 : '';
            $item->p72 = $item->p72 ? $item->p72 : '';
            $item->protective_part = $item->protective_part ? $item->protective_part : '';
            $item->satuan = $item->satuan ? $item->satuan : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            // $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            // $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            // $item->userRole = User::where('id', $item->user_id)->first()->role ?? '';
            // $item->no_sph = $item->no_sph ? $item->no_sph : '';
            // $item->tanggal_sph = $item->tanggal_sph ? $item->tanggal_sph : '';
            // $item->no_just = $item->no_just ? $item->no_just : '';
            // $item->tanggal_just = $item->tanggal_just ? $item->tanggal_just : '';
            // $item->no_nego1 = $item->no_nego1 ? $item->no_nego1 : '';
            // $item->tanggal_nego1 = $item->tanggal_nego1 ? $item->tanggal_nego1 : '';
            // $item->batas_nego1 = $item->batas_nego1 ? $item->batas_nego1 : '';
            // $item->no_nego2 = $item->no_nego2 ? $item->no_nego2 : '';
            // $item->tanggal_nego2 = $item->tanggal_nego2 ? $item->tanggal_nego2 : '';
            // $item->batas_nego2 = $item->batas_nego2 ? $item->batas_nego2 : '';
            // $item->batas_akhir = Purchase_Order::leftjoin('detail_po', 'detail_po.id_po', '=', 'purchase_order.id')->where('detail_po.id_detail_pr', $item->id)->first()->batas_akhir ?? '-';

            // $ekspedisi = RegistrasiBarang::where('id_barang', $item->id)->first();
            // if ($ekspedisi) {
            //     $keterangan = $ekspedisi->keterangan;
            //     $tanggal = $ekspedisi->created_at;
            //     $tanggal = Carbon::parse($tanggal)->isoFormat('D MMMM Y');
            //     $keterangan = $keterangan . ', ' . $tanggal;
            // } else {
            //     $keterangan = null;
            // }
            // $item->ekspedisi = $keterangan;

            // //qc
            // if ($ekspedisi) {
            //     $qc = Lppb::where('id_registrasi_barang', $ekspedisi->id)->first();
            // } else {
            //     $qc = null;
            // }

            // if ($qc) {
            //     $penerimaan = $qc->penerimaan;
            //     $hasil_ok = $qc->hasil_ok;
            //     $hasil_nok = $qc->hasil_nok;
            //     $tanggal_qc = $qc->created_at;
            //     $tanggal_qc = Carbon::parse($qc->created_at)->isoFormat('D MMMM Y');
            //     $qc = new stdClass();
            //     $qc->penerimaan = $penerimaan;
            //     $qc->hasil_ok = $hasil_ok;
            //     $qc->hasil_nok = $hasil_nok;
            //     $qc->tanggal_qc = $tanggal_qc;
            // } else {
            //     $penerimaan = null;
            //     $hasil_ok = null;
            //     $hasil_nok = null;
            //     $tanggal_qc = null;
            //     $qc = null;
            // }

            // $item->qc = $qc;

            //countdown = waktu - date now
            $targetDate = Carbon::parse($item->waktu);
            $currentDate = Carbon::now();
            $diff = $currentDate->diff($targetDate);
            $remainingDays = $diff->days;

            $referenceDate = Carbon::parse($item->waktu); // Change this to your desired reference date

            if ($currentDate->lessThan($referenceDate)) {
                // If the current date is before the reference date
                $item->countdown = "$remainingDays  Hari Sebelum Waktu Penyelesaian";
                $item->backgroundcolor = "#FF0000"; // Red background
            } elseif ($currentDate->greaterThanOrEqualTo($referenceDate)) {
                // If the current date is on or after the reference date
                $item->countdown = "$remainingDays Hari Setelah Waktu Penyelesaian";
                $item->backgroundcolor = "#008000"; // Green background
            }
            return $item;
        });
        return response()->json([
            'pr' => $pr
        ]);
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
        //Store untuk menambah data
        $bom = $request->id;
        $request->validate(
            [
                'proyek_id' => 'nullable',
                'nomor' => 'nullable',
                'proyek'=> 'nullable',
                'tanggal'=> 'required|date',
                'kode_material'=> 'nullable',
                'deskripsi_material'=> 'nullable',
                'spesifikasi'=> 'nullable',
                'p1'=> 'nullable',
                'p3'=> 'nullable',
                'p6'=> 'nullable',
                'p12'=> 'nullable',
                'p24'=> 'nullable',
                'p36'=> 'nullable',
                'p48'=> 'nullable',
                'p60'=> 'nullable',
                'p72'=> 'nullable',
                'protective_part'=> 'nullable',
                'satuan'=> 'nullable',
                'keterangan'=> 'nullable',
            ],
            [
                'proyek_id.required' => 'Proyek harus diisi',
                'nomor.required' => 'No PR harus diisi',
                'tanggal.required' => 'Dasar PR harus diisi',
                
            ]
        );

        if (empty($bom)) {
            DB::table('bom')->insert([
                'proyek_id' => $request->proyek_id,
                'nomor' => $request->nomor,
                'proyek' => $request->proyek,
                'tanggal' => $request->tanggal,
                'kode_material' => $request->kode_material,
                'deskripsi_material' => $request->deskripsi_material,
                'spesifikasi' => $request->spesifikasi,
                'p1' => $request->p1,
                'p3' => $request->p3,
                'p6' => $request->p6,
                'p12' => $request->p12,
                'p24' => $request->p24,
                'p36' => $request->p36,
                'p48' => $request->p48,
                'p60' => $request->p60,
                'p72' => $request->p72,
                'protective_part' => $request->protective_part,
                'satuan' => $request->satuan,
                'keterangan' => $request->keterangan,
                // 'id_user' => auth()->user()->id,
            ]);

            return redirect()->route('bom.index')->with('success', 'BOM berhasil ditambahkan');
        } else {
            DB::table('bom')->where('id', $bom)->update([
                'proyek_id' => $request->proyek_id,
                'nomor' => $request->nomor,
                'proyek' => $request->proyek,
                'tanggal' => $request->tanggal,
                'kode_material' => $request->kode_material,
                'deskripsi_material' => $request->deskripsi_material,
                'spesifikasi' => $request->spesifikasi,
                'p1' => $request->p1,
                'p3' => $request->p3,
                'p6' => $request->p6,
                'p12' => $request->p12,
                'p24' => $request->p24,
                'p36' => $request->p36,
                'p48' => $request->p48,
                'p60' => $request->p60,
                'p72' => $request->p72,
                'protective_part' => $request->protective_part,
                'satuan' => $request->satuan,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('bom.index')->with('success', 'BOM berhasil diupdate');
        }

        // return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil disimpan');

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
