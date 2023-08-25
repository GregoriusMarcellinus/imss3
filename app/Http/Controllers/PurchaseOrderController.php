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

        $purchases = Purchase_Order::paginate(50);

        if ($search) {
            $purchases = Purchase_Order::where('no_po', 'LIKE', "%$search%")->paginate(50);
        }

        if ($request->format == "json") {
            $purchases = Purchase_Order::where("warehouse_id", $warehouse_id)->get();

            return response()->json($purchases);
        } else {
            return view('purchase_order', compact('purchases'));
        }
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
        $purchase_order = $request->id;
        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }
        $request->validate(
            [
                'no_po' => 'required',
                'vendor_id' => 'required',
                'tanggal_po' => 'required',
                'batas_po' => 'required'
            ],
            [
                'no_po.required' => 'No. PO harus diisi',
                'vendor_id.required' => 'Vendor harus diisi',
                'tanggal_po.required' => 'Tanggal PO harus diisi',
                'batas_po.required' => 'Batas Akhir PO harus diisi'
            ]
        );

        if (empty($purchase_order)) {
            DB::table('purchase_order')->insert([
                'no_po' => $request->no_po,
                'vendor_id' => $request->vendor_id,
                "tanggal_po"  => Carbon::now()->setTimezone('Asia/Jakarta'),
                "batas_po" => Carbon::now()->setTimezone('Asia/Jakarta')
            ]);

            return redirect()->route('purchase_order.index')->with('success', 'Data PO berhasil ditambahkan');
        } else {
            DB::table('purchase_order')->where('id', $purchase_order)->update([
                'no_po' => $request->no_po,
                'vendor_id' => $request->vendor_id,
                "tanggal_po"  => Carbon::now()->setTimezone('Asia/Jakarta'),
                "batas_po" => Carbon::now()->setTimezone('Asia/Jakarta')
            ]);

            return redirect()->route('purchase_order.index')->with('success', 'Data PO berhasil diubah');
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
    public function destroy($id)
    {
        //
    }
}
