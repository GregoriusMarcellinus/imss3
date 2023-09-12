<?php

namespace App\Http\Controllers;

use App\Models\DetailPR;
use App\Models\Purchase_Order;
use App\Models\PurchaseRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseOrderController extends Controller
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

        $purchases = Purchase_Order::select('purchase_order.*', 'vendor.nama as vendor_name', 'keproyekan.nama_proyek as proyek_name')
            ->join('vendor', 'vendor.id', '=', 'purchase_order.vendor_id')
            ->leftjoin('keproyekan', 'keproyekan.id', '=', 'purchase_order.proyek_id')
            ->paginate(50);
        $vendors = DB::table('vendor')->get();
        $proyeks = DB::table('keproyekan')->get();

        if ($search) {
            $purchases = Purchase_Order::where('no_po', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $purchases = Purchase_Order::where("warehouse_id", $warehouse_id)->get();

            return response()->json($purchases);
        } else {
            $prs = PurchaseRequest::all();
            return view('purchase_order', compact('purchases', 'vendors', 'proyeks', 'prs'));
        }
    }

    public function indexApps(Request $request)
    {
        $search = $request->q;

        $purchases = Purchase_Order::select('purchase_order.*', 'vendor.nama as vendor_name', 'keproyekan.nama_proyek as proyek_name')
            ->join('vendor', 'vendor.id', '=', 'purchase_order.vendor_id')
            ->leftjoin('keproyekan', 'keproyekan.id', '=', 'purchase_order.proyek_id')
            ->paginate(50);
        $vendors = DB::table('vendor')->get();
        $proyeks = DB::table('keproyekan')->get();

        if ($search) {
            $purchases = Purchase_Order::where('no_po', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $purchases = Purchase_Order::all();

            return response()->json($purchases);
        } else {
            return view('home.apps.logistik.purchase_order', compact('purchases', 'vendors', 'proyeks'));
        }
    }

    public function getDetailPo(Request $request)
    {
        $id = $request->id;
        $po = Purchase_Order::select('purchase_order.*', 'vendor.nama as nama_vendor', 'keproyekan.nama_proyek as nama_proyek')
            ->join('vendor', 'vendor.id', '=', 'purchase_order.vendor_id')
            ->leftjoin('keproyekan', 'keproyekan.id', '=', 'purchase_order.proyek_id')
            ->where('purchase_order.id', $id)
            ->first();
        $po->details = [];
        return response()->json([
            'po' => $po
        ]);
    }

    public function updateDetailPo(Request $request)
    {
        $id = $request->id;
        $po = Purchase_Order::where('id', $id)->update([
            'no_po' => $request->no_po,
            'vendor_id' => $request->vendor_id,
            'tanggal_po' => $request->tanggal_po,
            'batas_po' => $request->batas_po,
            'incoterm' => $request->incoterm,
            'pr_no' => $request->pr_no,
            'ref_sph' => $request->ref_sph,
            'no_just' => $request->no_just,
            'no_nego' => $request->no_nego,
            'ref_po' => $request->ref_po,
            'term_pay' => $request->term_pay,
            'garansi' => $request->garansi,
            'proyek_id' => $request->proyek_id,
        ]);
        return response()->json([
            'po' => $po
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
        $purchase_order = $request->id;
        // $vendors = DB::table('vendor')->get();

        // if (Session::has('selected_warehouse_id')) {
        //     $warehouse_id = Session::get('selected_warehouse_id');
        // } else {
        //     $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        // }
        $request->validate(
            [
                'no_po' => 'required',
                'vendor_id' => 'required',
                'tanggal_po' => 'required',
                'batas_po' => 'required',
                'incoterm' => 'required',
                'pr_id' => 'required',
                'term_pay' => 'required',
                'proyek_id' => 'required',

            ],
            [
                'no_po.required' => 'No. PO harus diisi',
                'vendor_id.required' => 'Vendor harus diisi',
                'tanggal_po.required' => 'Tanggal PO harus diisi',
                'batas_po.required' => 'Batas Akhir PO harus diisi',
                'incoterm.required' => 'Incoterm harus diisi',
                'pr_id.required' => 'PR harus diisi',
                'term_pay.required' => 'Termin Pembayaran harus diisi',
                'proyek_id.required' => 'Proyek harus diisi',
            ]
        );

        if (empty($purchase_order)) {
            DB::table('purchase_order')->insert([
                'no_po' => $request->no_po,
                'vendor_id' => $request->vendor_id,
                'tanggal_po' => $request->tanggal_po,
                'batas_po' => $request->batas_po,
                'incoterm' => $request->incoterm,
                'ref_sph' => $request->ref_sph,
                'no_just' => $request->no_just,
                'no_nego' => $request->no_nego,
                'ref_po' => $request->ref_po,
                'term_pay' => $request->term_pay,
                'garansi' => $request->garansi,
                'proyek_id' => $request->proyek_id,
                'pr_id' => $request->pr_id,
                'catatan_vendor' => $request->catatan_vendor

            ]);

            return redirect()->route('purchase_order.index')->with('success', 'Data PO berhasil ditambahkan');
        } else {
            DB::table('purchase_order')->where('id', $purchase_order)->update([
                'no_po' => $request->no_po,
                'vendor_id' => $request->vendor_id,
                // "tanggal_po"  => Carbon::now()->setTimezone('Asia/Jakarta'),
                // "batas_po" => Carbon::now()->setTimezone('Asia/Jakarta')
                'tanggal_po' => $request->tanggal_po,
                'batas_po' => $request->batas_po,
                'incoterm' => $request->incoterm,
                'pr_no' => $request->pr_no,
                'ref_sph' => $request->ref_sph,
                'no_just' => $request->no_just,
                'no_nego' => $request->no_nego,
                'ref_po' => $request->ref_po,
                'term_pay' => $request->term_pay,
                'garansi' => $request->garansi,
                'proyek_id' => $request->proyek_id,
                // 'catatan_vendor' => $request->catatan_vendor

            ]);
            return redirect()->route('purchase_order.index')->with('success', 'Data PO berhasil diubah');
        }
    }

    public function cetakPo(Request $request)
    {
        $id = $request->id_po;
        $po = Purchase_Order::select('purchase_order.*', 'vendor.nama as nama_vendor', 'vendor.alamat as alamat_vendor', 'vendor.telp as telp_vendor', 'vendor.email as email_vendor', 'vendor.fax as fax_vendor',  'keproyekan.nama_proyek as nama_proyek', 'purchase_request.no_pr as pr_no')
            ->join('vendor', 'vendor.id', '=', 'purchase_order.vendor_id')
            ->leftjoin('keproyekan', 'keproyekan.id', '=', 'purchase_order.proyek_id')
            ->leftjoin('purchase_request', 'purchase_request.id', '=', 'purchase_order.pr_id')
            ->where('purchase_order.id', $id)
            ->first();
        $po->batas_po = Carbon::parse($po->batas_po)->isoFormat('D MMMM Y');
        $po->tanggal_po = Carbon::parse($po->tanggal_po)->isoFormat('D MMMM Y');
        $po->details = DetailPR::where('id_pr', $po->pr_id)->get();
        $pdf = PDF::loadview('po_print', compact('po'));
        $pdf->setPaper('A4', 'landscape');
        $nama = $po->nama_proyek;
        return $pdf->stream('PO-' . $nama . '.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $delete_po = $request->id;
        $delete_po = DB::table('purchase_order')->where('id', $delete_po)->delete();

        if ($delete_po) {
            return redirect()->route('purchase_order.index')->with('success', 'Data PO berhasil dihapus');
        } else {
            return redirect()->route('purchase_order.index')->with('error', 'Data PO gagal dihapus');
        }

        return redirect()->route('purchase_order.index');
    }
}
