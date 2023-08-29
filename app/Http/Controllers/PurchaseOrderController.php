<?php

namespace App\Http\Controllers;

use App\Models\Purchase_Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
            return view('purchase_order', compact('purchases', 'vendors', 'proyeks'));
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
        return response()->json([
            'po' => $po
        ]); 
    
    }

    public function updateDetailPo(Request $request){
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
                'pr_no' => 'required',
                'term_pay' => 'required',
                'proyek_id' => 'required',

            ],
            [
                'no_po.required' => 'No. PO harus diisi',
                'vendor_id.required' => 'Vendor harus diisi',
                'tanggal_po.required' => 'Tanggal PO harus diisi',
                'batas_po.required' => 'Batas Akhir PO harus diisi',
                'incoterm.required' => 'Incoterm harus diisi',
                'pr_no.required' => 'PR No. harus diisi',
                'term_pay.required' => 'Termin Pembayaran harus diisi',
                'proyek_id.required' => 'Proyek harus diisi',
            ]
        );

        if (empty($purchase_order)) {
            DB::table('purchase_order')->insert([
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
