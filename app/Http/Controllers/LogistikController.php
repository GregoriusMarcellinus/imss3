<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LogistikController extends Controller
{
    public function index()
    {
        if (Session::has('selected_warehouse_id')) {
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }
        $products = DB::table('products')->get();
        $products = $products->map(function ($item) use ($warehouse_id) {
            $totalStockIn   = DB::table('stock')->where([["warehouse_id", $warehouse_id], ["product_id", $item->product_id], ["type", 1]])->sum("product_amount");
            $totalStockOut  = DB::table('stock')->where([["warehouse_id", $warehouse_id], ["product_id", $item->product_id], ["type", 0]])->sum("product_amount");
            $availableStock = $totalStockIn - $totalStockOut;
            $item->actual_stock = $totalStockIn;
            $item->available_stock = $availableStock;
            $item->trackings = DB::table('stock')->where([["stock.warehouse_id", $warehouse_id], ["stock.product_id", $item->product_id], ["type", 0]])->leftJoin('keproyekan', 'stock.proyek_id', '=', 'keproyekan.id')->select('stock.*', 'keproyekan.nama_proyek as nama_proyek')->get();
            return $item;
        });

        // dd($products);
        return view('logistik', compact('products'));
    }
}
