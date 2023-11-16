<?php

namespace App\Http\Controllers;

use App\Models\DetailPo;
use App\Models\DetailPR;
use App\Models\DetailSpph;
use App\Models\Keproyekan;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
use App\Models\Spph;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use stdClass;

class PurchaseRequestController extends Controller
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

        $requests = PurchaseRequest::select('purchase_request.*', 'keproyekan.nama_proyek as proyek_name')
            ->join('keproyekan', 'keproyekan.id', '=', 'purchase_request.proyek_id')
            ->orderBy('purchase_request.id', 'asc')
            ->paginate(50);

        $proyeks = DB::table('keproyekan')->get();
        //  dd($requests);

        if ($search) {
            $requests = PurchaseRequest::where('nama_proyek', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $requests = PurchaseRequest::where("warehouse_id", $warehouse_id)->get();

            return response()->json($requests);
        } else {

            //looping the paginate
            foreach ($requests as $request) {
                $detail_pr = DetailPR::where('id_pr', $request->id)->get();
                //if detail_pr empty then editable true
                if ($detail_pr->isEmpty()) {
                    $request->editable = TRUE;
                } else {
                    //looping detail_pr then check in detailspph with id_detail_pr exist
                    foreach ($detail_pr as $detail) {
                        $detail_spph = DetailSpph::where('id_detail_pr', $detail->id)->first();
                        $po = Purchase_Order::where('id', $detail->id_po)->first();
                        if ($po && $po->tipe == '1'){
                            $request->editable = FALSE;
                            break;
                            
                        } else{
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
            return view('purchase_request.purchase_request', compact('requests', 'proyeks'));
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

        $requests = PurchaseRequest::select('purchase_request.*', 'keproyekan.nama_proyek as proyek_name')
            ->join('keproyekan', 'keproyekan.id', '=', 'purchase_request.proyek_id')
            ->paginate(50);

        $proyeks = DB::table('keproyekan')->get();

        if ($search) {
            $requests = PurchaseRequest::where('nama_proyek', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $requests = PurchaseRequest::where("warehouse_id", $warehouse_id)->get();

            return response()->json($requests);
        } else {
            return view('home.apps.wilayah.purchase_request', compact('requests', 'proyeks'));
        }
    }


    public function getDetailPr(Request $request)
    {
        $id = $request->id;
        $pr = PurchaseRequest::select('purchase_request.*', 'keproyekan.nama_proyek as nama_proyek')
            ->join('keproyekan', 'keproyekan.id', '=', 'purchase_request.proyek_id')
            ->where('purchase_request.id', $id)
            ->first();
        $pr->details = DetailPR::where('id_pr', $id)->get();
        // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
        $pr->details = $pr->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            $item->userRole = User::where('id', $item->user_id)->first()->role ?? '';
            $item->no_sph = $item->no_sph ? $item->no_sph : '';
            $item->tanggal_sph = $item->tanggal_sph ? $item->tanggal_sph : '';
            $item->no_just = $item->no_just ? $item->no_just : '';
            $item->tanggal_just = $item->tanggal_just ? $item->tanggal_just : '';
            $item->no_nego1 = $item->no_nego1 ? $item->no_nego1 : '';
            $item->tanggal_nego1 = $item->tanggal_nego1 ? $item->tanggal_nego1 : '';
            $item->batas_nego1 = $item->batas_nego1 ? $item->batas_nego1 : '';
            $item->no_nego2 = $item->no_nego2 ? $item->no_nego2 : '';
            $item->tanggal_nego2 = $item->tanggal_nego2 ? $item->tanggal_nego2 : '';
            $item->batas_nego2 = $item->batas_nego2 ? $item->batas_nego2 : '';
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $purchase_request = $request->id;
        $request->validate(
            [
                'proyek_id' => 'required',
                'no_pr' => 'required',
                'dasar_pr' => 'required',
                'tgl_pr' => 'required',
            ],
            [
                'proyek_id.required' => 'Proyek harus diisi',
                'no_pr.required' => 'No PR harus diisi',
                'dasar_pr.required' => 'Dasar PR harus diisi',
                'tgl_pr.required' => 'Tanggal PR harus diisi',
            ]
        );

        if (empty($purchase_request)) {
            DB::table('purchase_request')->insert([
                'proyek_id' => $request->proyek_id,
                'no_pr' => $request->no_pr,
                'dasar_pr' => $request->dasar_pr,
                'tgl_pr' => $request->tgl_pr,
            ]);

            return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil ditambahkan');
        } else {
            DB::table('purchase_request')->where('id', $purchase_request)->update([
                'proyek_id' => $request->proyek_id,
                'no_pr' => $request->no_pr,
                'dasar_pr' => $request->dasar_pr,
                'tgl_pr' => $request->tgl_pr,
            ]);

            return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil diupdate');
        }

        // return redirect()->route('purchase_request.index')->with('success', 'Purchase Request berhasil disimpan');

    }

    public function cetakPr(Request $request)
    {
        $id = $request->id;
        $pr = PurchaseRequest::where('purchase_request.id', $id)
            ->leftjoin('keproyekan', 'keproyekan.id', '=', 'purchase_request.proyek_id')->first();
        $pr->purchases = DetailPR::select('detail_pr.*', 'purchase_request.*')
            ->leftjoin('purchase_request', 'purchase_request.id', '=', 'detail_pr.id_pr')
            ->where('purchase_request.id', $id)
            ->get();

        // return response()->json([
        //     'pr' => $pr
        // ]);
        // dd($po);
        // $po->batas_po = Carbon::parse($po->batas_po)->isoFormat('D MMMM Y');
        // $po->tanggal_po = Carbon::parse($po->tanggal_po)->isoFormat('D MMMM Y');

        $pdf = Pdf::loadview('purchase_request.pr_print', compact('pr'));
        $pdf->setPaper('A4', 'landscape');
        $no = $pr->no_pr;
        return $pdf->stream('PR-' . $no . '.pdf');
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
    public function updateDetailPr(Request $request)
    {
        if (!$request->stock) {
            return response()->json([
                'success' => false,
                'message' => 'QTY tidak boleh kosong'
            ]);
        }

        $insert = DetailPR::create([
            'id_pr' => $request->id_pr,
            'id_proyek' => $request->id_proyek,
            'kode_material' => $request->kode_material,
            'uraian' => $request->uraian,
            'spek' => $request->spek,
            'satuan' => $request->satuan,
            'qty' => $request->stock,
            'waktu' => $request->waktu,
            'keterangan' => $request->keterangan,
        ]);

        if (!$insert) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan detail PR'
            ]);
        }

        $pr = DB::table('purchase_request')->where('id', $request->id_pr)->first();
        $pr->details = DetailPR::where('id_pr', $request->id_pr)->get();
        $pr->details = $pr->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambahkan detail PR',
            'pr' => $pr
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $delete_pr = $request->id;
        $delete_pr = DB::table('purchase_request')->where('id', $delete_pr)->delete();
        $delete_detail_pr = DetailPR::where('id_pr', $request->id)->delete();
        // $delete_detail_po = DetailPo::where('id_pr', $request->id)->delete();
        // $delete_detail_spph = Spph::leftjoin('detail_spph', 'detail_spph.spph_id', '=', 'spph.id')->where('detail_spph.id_detail_pr', $request->id)->delete();

        // if ($delete_pr && $delete_detail_pr && $delete_detail_po && $delete_detail_spph) {
        if ($delete_pr) {
            return redirect()->route('purchase_request.index')->with('success', 'Data Request berhasil dihapus');
        } else {
            return redirect()->route('purchase_request.index')->with('error', 'Data Request gagal dihapus');
        }

        return redirect()->route('purchase_request.index');
    }

    public function detailPrSave(Request $request)
    {
        $id_pr = $request->id;
        $id = $request->id_pr;
        $no_sph = $request->no_sph;
        $tanggal_sph = $request->tanggal_sph;
        $no_just = $request->no_just;
        $tanggal_just = $request->tanggal_just;
        $no_nego1 = $request->no_nego1;
        $tanggal_nego1 = $request->tanggal_nego1;
        $batas_nego1 = $request->batas_nego1;
        $no_nego2 = $request->no_nego2;
        $tanggal_nego2 = $request->tanggal_nego2;
        $batas_nego2 = $request->batas_nego2;

        DetailPR::where('id', $id_pr)->update([
            'no_sph' => $no_sph,
            'tanggal_sph' => $tanggal_sph,
            'no_just' => $no_just,
            'tanggal_just' => $tanggal_just,
            'no_nego1' => $no_nego1,
            'tanggal_nego1' => $tanggal_nego1,
            'batas_nego1' => $batas_nego1,
            'no_nego2' => $no_nego2,
            'tanggal_nego2' => $tanggal_nego2,
            'batas_nego2' => $batas_nego2,
        ]);

        $pr = PurchaseRequest::where('id', $id)->first();
        $pr->details = DetailPR::where('id_pr', $pr->id)->get();
        // $pr->details = DetailPR::where('id_pr', $id)->leftJoin('kode_material', 'kode_material.id', '=', 'detail_pr.kode_material_id')->get();
        $pr->details = $pr->details->map(function ($item) {
            $item->spek = $item->spek ? $item->spek : '';
            $item->keterangan = $item->keterangan ? $item->keterangan : '';
            $item->kode_material = $item->kode_material ? $item->kode_material : '';
            $item->nomor_spph = Spph::where('id', $item->id_spph)->first()->nomor_spph ?? '';
            $item->no_po = Purchase_Order::where('id', $item->id_po)->first()->no_po ?? '';

            $item->no_sph = $item->no_sph ?? '';
            $item->tanggal_sph = $item->tanggal_sph ?? '';
            $item->no_just = $item->no_just ?? '';
            $item->tanggal_just = $item->tanggal_just ?? '';
            $item->no_nego1 = $item->no_nego1 ?? '';
            $item->tanggal_nego1 = $item->tanggal_nego1 ?? '';
            $item->batas_nego1 = $item->batas_nego1 ?? '';
            $item->no_nego2 = $item->no_nego2 ?? '';
            $item->tanggal_nego2 = $item->tanggal_nego2 ?? '';
            $item->batas_nego2 = $item->batas_nego2 ?? '';
            return $item;
        });
        return response()->json([
            'pr' => $pr
        ]);
    }
}
