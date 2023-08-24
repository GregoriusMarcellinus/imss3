<?php

namespace App\Http\Controllers;

use App\Exports\HistoryExport;
use App\Exports\WIPHistoryExport;
use App\Exports\ProductsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use DNS1D;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Excel;
use App\Imports\ProductsImport;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        if(!Session::has('selected_warehouse_id')){
            $warehouse = DB::table('warehouse')->first();
            Session::put('selected_warehouse_id', $warehouse->warehouse_id);
            Session::put('selected_warehouse_name', $warehouse->warehouse_name);
        }
    }

    public function products(Request $req){
        $sort           = $req->sort;
        $search         = $req->q;
        $cat            = $req->category;
        $dl             = $req->dl;

        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $products = DB::table('products')
                    ->leftJoin("categories", "products.category_id", "=", "categories.category_id")
                    ->select("products.*", "categories.*");
        
        $productsExport = $products;
        
        if(!empty($cat)){
            $products = $products->orWhere([["categories.category_id", $cat], ["products.warehouse_id", $warehouse_id]]);
        }
        
        if(!empty($search)){
            $products = $products->orWhere([["products.product_name", "LIKE", "%".$search."%"], ["products.warehouse_id", $warehouse_id]])
                        ->orWhere([["products.product_code", "LIKE", "%".$search."%"], ["products.warehouse_id", $warehouse_id]]);
        }
        
        if(!empty($sort)){
            if($sort == "category_az"){
                $products = $products->orderBy("categories.category_name", "asc");
            } else if($sort == "category_za"){
                $products = $products->orderBy("categories.category_name", "desc");
            } else if($sort == "name_az"){
                $products = $products->orderBy("products.product_name", "asc");
            } else if($sort == "name_za"){
                $products = $products->orderBy("products.product_name", "desc");
            } else {
                $products = $products->orderBy("products.product_id", "desc");
            }
        }

        $products = $products->paginate(50);

        $warehouse = $this->getWarehouse();

        if(!empty($dl)){
            $tmp            = $productsExport->orderBy("products.product_id", "asc")->get();
            $fn             = 'products_'.time();

            foreach($tmp as $p){
                $totalStockIn   = DB::table('stock')->where([["product_id", $p->product_id], ["type", 1]])->sum("product_amount");
                $totalStockOut  = DB::table('stock')->where([["product_id", $p->product_id], ["type", 0]])->sum("product_amount");
                $availableStock = $totalStockIn-$totalStockOut;
                $p->product_amount = $availableStock;
            }

            $productExport  = [];

            foreach($tmp as $t){
                $productExport[] = [
                    "KODE BARANG"         => $t->product_code,
                    "NAMA BARANG"         => $t->product_name,
                    "SPESIFIKASI"         => $t->spesifikasi,                   
                    "STOK"                => $t->product_amount,
                    "satuan"              => $t->satuan,
                    "LOKASI"              => $t->category_name,
                    
                ];
            }

            if($dl == "xls"){
                return (new ProductsExport($productExport))->download($fn.'.xls', \Maatwebsite\Excel\Excel::XLS);
            } else if($dl == "pdf"){
                return (new ProductsExport($productExport))->download($fn.'.pdf');
            }
        } else {
            foreach($products as $p){
                $totalStockIn   = DB::table('stock')->where([["product_id", $p->product_id], ["type", 1]])->sum("product_amount");
                $totalStockOut  = DB::table('stock')->where([["product_id", $p->product_id], ["type", 0]])->sum("product_amount");
                $availableStock = $totalStockIn-$totalStockOut;
                $p->product_amount = $availableStock;
            }
        }

        return View::make("products")->with(compact("products", "warehouse"));
    }

    #coba SJN
    public function sjn(Request $req){
        $sort           = $req->sort;
        $search         = $req->q;
        $cat            = $req->category;
        $dl             = $req->dl;

        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $sjn = DB::table('sjn')
                    ->leftJoin("categories", "sjn.category_id", "=", "categories.category_id")
                    ->select("sjn.*", "categories.*");
        
        $sjnExport = $sjn;
        
        if(!empty($cat)){
            $products = $products->orWhere([["categories.category_id", $cat], ["sjn.warehouse_id", $warehouse_id]]);
        }
        
        if(!empty($search)){
            $products = $products->orWhere([["sjn.nama_barang", "LIKE", "%".$search."%"], ["sjn.warehouse_id", $warehouse_id]])
                        ->orWhere([["sjn.kode_material", "LIKE", "%".$search."%"], ["sjn.warehouse_id", $warehouse_id]]);
        }
        
        if(!empty($sort)){
            if($sort == "category_az"){
                $sjn = $sjn->orderBy("categories.category_name", "asc");
            } else if($sort == "category_za"){
                $sjn = $sjn->orderBy("categories.category_name", "desc");
            } else if($sort == "name_az"){
                $sjn = $sjn->orderBy("sjn.nama_barang", "asc");
            } else if($sort == "name_za"){
                $sjn = $sjn->orderBy("sjn.nama_barang", "desc");
            } else {
                $sjn = $sjn->orderBy("sjn.product_id", "desc");
            }
        }

        $sjn = $sjn->paginate(50);

        $warehouse = $this->getWarehouse();

        if(!empty($dl)){
            $tmp            = $productsExport->orderBy("sjn.product_id", "asc")->get();
            $fn             = 'sjn_'.time();

            foreach($tmp as $p){
                $totalStockIn   = DB::table('stock')->where([["product_id", $p->product_id], ["type", 1]])->sum("product_amount");
                $totalStockOut  = DB::table('stock')->where([["product_id", $p->product_id], ["type", 0]])->sum("product_amount");
                $availableStock = $totalStockIn-$totalStockOut;
                $p->product_amount = $availableStock;
            }

            $productExport  = [];

            foreach($tmp as $t){
                $productExport[] = [
                    "KODE BARANG"         => $t->product_code,
                    "NAMA BARANG"         => $t->product_name,
                    "SPESIFIKASI"         => $t->spesifikasi,                   
                    "STOK"                => $t->product_amount,
                    "satuan"              => $t->satuan,
                    "LOKASI"              => $t->category_name,
                    
                ];
            }

            if($dl == "xls"){
                return (new ProductsExport($productExport))->download($fn.'.xls', \Maatwebsite\Excel\Excel::XLS);
            } else if($dl == "pdf"){
                return (new ProductsExport($productExport))->download($fn.'.pdf');
            }
        } else {
            foreach($sjn as $p){
                $totalStockIn   = DB::table('stock')->where([["product_id", $p->product_id], ["type", 1]])->sum("product_amount");
                $totalStockOut  = DB::table('stock')->where([["product_id", $p->product_id], ["type", 0]])->sum("product_amount");
                $availableStock = $totalStockIn-$totalStockOut;
                $p->product_amount = $availableStock;
            }
        }

        return View::make("sjn")->with(compact("sjn", "warehouse"));
    }
    #Coba SJN
    

    #Print SJN
    public function sjn_print(Request $req){
        $sort           = $req->sort;
        $search         = $req->q;
        $cat            = $req->category;
        $dl             = $req->dl;

        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $sjn_print = DB::table('sjn')
                    ->leftJoin("categories", "sjn.category_id", "=", "categories.category_id")
                    ->select("sjn.*", "categories.*");
        
        $sjn_printExport = $sjn_print;
        
        if(!empty($cat)){
            $products = $products->orWhere([["categories.category_id", $cat], ["sjn.warehouse_id", $warehouse_id]]);
        }
        
        if(!empty($search)){
            $products = $products->orWhere([["sjn.nama_barang", "LIKE", "%".$search."%"], ["sjn.warehouse_id", $warehouse_id]])
                        ->orWhere([["sjn.kode_material", "LIKE", "%".$search."%"], ["sjn.warehouse_id", $warehouse_id]]);
        }
        
        if(!empty($sort)){
            if($sort == "category_az"){
                $sjn = $sjn->orderBy("categories.category_name", "asc");
            } else if($sort == "category_za"){
                $sjn = $sjn->orderBy("categories.category_name", "desc");
            } else if($sort == "name_az"){
                $sjn = $sjn->orderBy("sjn.nama_barang", "asc");
            } else if($sort == "name_za"){
                $sjn = $sjn->orderBy("sjn.nama_barang", "desc");
            } else {
                $sjn = $sjn->orderBy("sjn.product_id", "desc");
            }
        }

        $sjn_print = $sjn_print->paginate(50);

        $warehouse = $this->getWarehouse();

        if(!empty($dl)){
            $tmp            = $productsExport->orderBy("sjn.product_id", "asc")->get();
            $fn             = 'sjn_'.time();

            foreach($tmp as $p){
                $totalStockIn   = DB::table('stock')->where([["product_id", $p->product_id], ["type", 1]])->sum("product_amount");
                $totalStockOut  = DB::table('stock')->where([["product_id", $p->product_id], ["type", 0]])->sum("product_amount");
                $availableStock = $totalStockIn-$totalStockOut;
                $p->product_amount = $availableStock;
            }

            $productExport  = [];

            foreach($tmp as $t){
                $productExport[] = [
                    "KODE BARANG"         => $t->product_code,
                    "NAMA BARANG"         => $t->product_name,
                    "SPESIFIKASI"         => $t->spesifikasi,                   
                    "STOK"                => $t->product_amount,
                    "satuan"              => $t->satuan,
                    "LOKASI"              => $t->category_name,
                    
                ];
            }

            if($dl == "xls"){
                return (new ProductsExport($productExport))->download($fn.'.xls', \Maatwebsite\Excel\Excel::XLS);
            } else if($dl == "pdf"){
                return (new ProductsExport($productExport))->download($fn.'.pdf');
            }
        } else {
            foreach($sjn_print as $p){
                $totalStockIn   = DB::table('stock')->where([["product_id", $p->product_id], ["type", 1]])->sum("product_amount");
                $totalStockOut  = DB::table('stock')->where([["product_id", $p->product_id], ["type", 0]])->sum("product_amount");
                $availableStock = $totalStockIn-$totalStockOut;
                $p->product_amount = $availableStock;
            }
        }

        return View::make("sjn_print")->with(compact("sjn_print", "warehouse"));
    }

    #Print SJN


    public function products_wip(Request $req){
        $search = $req->q;
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $products = DB::table('products_wip')
                    ->leftJoin("products", "products_wip.product_id", "=", "products.product_id")
                    ->select("products_wip.*", "products.*");
        
        if(!empty($search)){
            $products = $products->orWhere([["products.product_name", "LIKE", "%".$search."%"], ["status", 0], ["products.warehouse_id", $warehouse_id]])
                        ->orWhere([["products.product_code", "LIKE", "%".$search."%"], ["status", 0], ["status", 0], ["products.warehouse_id", $warehouse_id]]);
        }
        
        $products = $products->where([["products_wip.status", 0], ["products_wip.warehouse_id", $warehouse_id]])->orderBy("products_wip.product_wip_id", "desc")->paginate(50);

        $warehouse = $this->getWarehouse();
        return View::make("products_wip")->with(compact("products", "warehouse"));
    }

    public function products_wip_history(Request $req){
        $search = $req->q;
        $dl     = $req->dl;

        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $products = DB::table('products_wip')
                    ->leftJoin("products", "products_wip.product_id", "=", "products.product_id")
                    ->select("products_wip.*", "products.*");
        
        if(!empty($search)){
            $products = $products->orWhere([["products.product_name", "LIKE", "%".$search."%"], ["status", 1]])
                        ->orWhere([["products.product_code", "LIKE", "%".$search."%"], ["status", 1]]);
        }
        
        $products = $products->where([["products_wip.status", 1], ["products_wip.warehouse_id", $warehouse_id]])->orderBy("products_wip.date_out", "desc");

        $warehouse = $this->getWarehouse();

        if(!empty($dl)){
            $tmp            = $products->orderBy("products_wip.product_wip_id", "asc")->get();
            $fn             = 'wip_history_'.time();
            $historyExport  = [];

            foreach($tmp as $t){
                $historyExport[] = [
                    "KODE PRODUK"       => $t->product_code,
                    "NAMA PRODUK"       => $t->product_name,
                    "JUMLAH"            => $t->product_amount,
                    "TANGGAL MASUK"     => date('d/m/Y', strtotime($t->date_in)),
                    "TANGGAL KELUAR"    => date('d/m/Y', strtotime($t->date_out)),
                ];
            }

            if($dl == "xls"){
                return (new WIPHistoryExport($historyExport))->download($fn.'.xls', \Maatwebsite\Excel\Excel::XLS);
            } else if($dl == "pdf"){
                return (new WIPHistoryExport($historyExport))->download($fn.'.pdf');
            }
        }

        $products = $products->paginate(50);

        return View::make("products_wip_history")->with(compact("products", "warehouse"));
    }

    public function product_check(Request $req){
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $product = DB::table('products')->where([["product_code", $req->pcode], ["warehouse_id", $warehouse_id]])->select("product_id", "product_code","product_name")->first();
        
        $result = ["status" => 0, "data" => null];

        if(!empty($product)){
            $result = ["status" => 1, "data" => $product];
        }
        
        return response()->json($result);
    }

    public function product_save(Request $req){
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $req->validate([
            'product_code'      => 'required|unique:products,product_code,'.$req->id.',product_id,warehouse_id,'.$warehouse_id,
            'product_name'      => 'required',
            'spesifikasi'    => 'required',
            'satuan'        => 'required',
            'category'          => 'required|exists:categories,category_id',
            
        ],
        [
            'product_code.required'     => 'Product Code belum diisi!',
            'product_code.unique'       => 'Product Code telah digunakan!',
            'product_name.required'     => 'Product Name belum diisi!',
            'spesifikasi.required'   => 'spesifikasi belum diisi!',
            
            'satuan.required'       => 'satuan belum diisi!',
            
            'category.required'         => 'Kategori belum dipilih!',
            'category.exists'           => 'Kategori tidak tersedia!',
        ]);

        $data = [
            "user_id"           => Auth::user()->id,
            "warehouse_id"      => $warehouse_id,
            "product_code"      => $req->product_code,
            "product_name"      => $req->product_name,
            "spesifikasi"    => $req->spesifikasi,
            "satuan"        => $req->satuan,
            "category_id"       => $req->category,
        ];

        if(empty($req->id)){
            $add = DB::table('products')->insertGetId($data);

            if($add){
                $req->session()->flash('success', "Product berhasil ditambahkan.");
            } else {
                $req->session()->flash('error', "Product gagal ditambahkan!");
            }
        } else {
            $update = DB::table('products')->where("product_id", $req->id)->update($data);

            if($update){
                $req->session()->flash('success', "Product berhasil diubah.");
            } else {
                $req->session()->flash('error', "Product gagal diubah!");
            }
        }
        
        return redirect()->back();
    }

    #coba save SJN
    public function product_sjn_save(Request $req){
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $req->validate([
            'kode_material'      => 'required|unique:products,product_code,'.$req->id.',product_id,warehouse_id,'.$warehouse_id,
            'nama_barang'      => 'required',
            'spesifikasi'    => 'required',
            'satuan'        => 'required',
            'proyek'          => 'required',
            'no_sjn'        => 'required',
            
        ],
        [
            'kode_material.required'     => 'Kode Material belum diisi!',
            'kode_material.unique'       => 'Kode Material telah digunakan!',
            'nama_barang.required'     => 'Nama Barang belum diisi!',
            'spesifikasi.required'   => 'spesifikasi belum diisi!',
            
            'satuan.required'       => 'satuan belum diisi!',
            
            'proyek.required'         => 'Kategori belum diisi!',
            
        ]);

        $data = [
            "user_id"           => Auth::user()->id,
            "warehouse_id"      => $warehouse_id,
            "kode_material"      => $req->kode_material,
            "nama_barang"      => $req->nama_barang,
            "spesifikasi"    => $req->spesifikasi,
            "satuan"        => $req->satuan,
            "proyek"       => $req->proyek,
            "no_sjn"       => $req->no_sjn,
        ];

        if(empty($req->id)){
            $add = DB::table('sjn')->insertGetId($data);

            if($add){
                $req->session()->flash('success', "Product berhasil ditambahkan.");
            } else {
                $req->session()->flash('error', "Product gagal ditambahkan!");
            }
        } else {
            $update = DB::table('sjn')->where("product_id", $req->id)->update($data);

            if($update){
                $req->session()->flash('success', "Product berhasil diubah.");
            } else {
                $req->session()->flash('error', "Product gagal diubah!");
            }
        }
        
        return redirect()->back();
    }
    #coba save SJN



    public function product_import(Request $req){
		$this->validate($req, [
			'file' => 'required|mimes:csv,xls,xlsx'
        ],
        [
            "file.required" => "File belum dipilih!",
            "file.mimes"    => "File harus dalam format CSV/XLS/XLSX!"
        ]);
 
		$file = $req->file('file');
 
		$filename = rand()."-".$file->getClientOriginalName();
 
		$file->move('upload/import',$filename);
 
		$import = Excel::toArray(new ProductsImport, public_path('upload/import/'.$filename));

        $data = [];
        foreach($import as $value){
            foreach($value as $v){
                $data[]=$v;
            }
        }

        $doneImport = 0;
        $countImport = count($data);
        foreach($data as $d){
            $checkExists = DB::table('products')
                        ->where("product_code", $d["KODE PRODUK"])
                        ->get()
                        ->count();

            if($checkExists == 0){
                if(Session::has('selected_warehouse_id')){
                    $warehouse_id = Session::get('selected_warehouse_id');
                } else {
                    $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
                }

                $param = [
                    'user_id'           => Auth::user()->id,
                    'warehouse_id'      => $warehouse_id,
                    'product_code'      => $d['KODE BARANG'],
                    'product_name'      => $d['NAMA BARANG'],
                    'spesifikasi'    => $d['spesifikasi'],
                    'satuan'        => $d['satuan'],
                ];

                $add = DB::table('products')->insertOrIgnore($param);

                if($add){
                    $doneImport++;
                }
            }
        }
        
        if($doneImport == $countImport){
            $req->session()->flash('success', "Semua data berhasil diimport.");
        } else {
            if($doneImport > 0){
                $req->session()->flash('success', "Sebagian data berhasil diimport.");
            } else {
                $req->session()->flash('error', "Data gagal diimport!");
            }
        }

		return redirect()->back();
    }

    public function product_wip_save(Request $req){
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $req->validate([
            'product_code'      => 'required|exists:products,product_code',
            'no_nota'           => 'required',
            'keterangan'        => 'required',
            'pamount'           => 'required|numeric',
            
        ],
        [
            'product_code.required' => 'Product Code belum diisi!',
            'product_code.exists'   => 'Product Code tidak ditemukan!',
            'no_nota.required'      => 'No. Nota belum diisi!',
            'keterangan.required'   => 'Keterangan belum diisi!',
            'pamount.required'      => 'Amount belum diisi!',
            'pamount.numeric'       => 'Amount harus berupa angka!',
        ]);

        $product_id = DB::table('products')
                        ->where([["product_code", $req->product_code], ["warehouse_id", $warehouse_id]])
                        ->select("product_id")
                        ->first();

        if(!empty($req->wip_date)){
            $req->validate([
                'wip_date'          => 'date_format:m/d/Y H:i:s',
                
            ],
            [
                'wip_date.date_format'      => 'Format tanggal salah! Format: BLN/TGL/THN JAM:MNT:DTK.',
            ]);
            $date_in = date('Y-m-d H:i:s', strtotime($req->wip_date));
        } else {
            $date_in = date("Y-m-d H:i:s");
        }

        if(!empty($product_id)){
            $product_id = $product_id->product_id;
            $data = [
                "product_id"        => $product_id,
                "warehouse_id"      => $warehouse_id,
                "keterangan"        => $req->keterangan,
                "no_nota"           => $req->no_nota,
                "product_amount"    => $req->pamount,
                "date_in"           => $date_in
            ];

            $add = DB::table('products_wip')->insertGetId($data);

            if($add){
                $req->session()->flash('success', "WIP berhasil ditambahkan.");
            } else {
                $req->session()->flash('error', "WIP gagal ditambahkan!");
            }
        } else {
            $req->session()->flash('error', "Product tidak ditemukan!");
        }

        return redirect()->back();
    }

    public function product_delete(Request $req){
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $del = DB::table('products')->where([["product_id", $req->id], ["warehouse_id", $warehouse_id]])->delete();

        if($del){
            $stock_id = DB::table('stock')->where([["product_id", $req->id], ["warehouse_id", $warehouse_id]])->first();
            if(!empty($stock_id)){
                $stock_id = $stock_id->stock_id;
                DB::table('stock')->where([["product_id", $req->id], ["warehouse_id", $warehouse_id]])->delete();
                DB::table('history')->where([["stock_id", $stock_id], ["warehouse_id", $warehouse_id]])->delete();
            }
            $req->session()->flash('success', "Product berhasil dihapus.");
        } else {
            $req->session()->flash('error', "Product gagal dihapus!");
        }

        return redirect()->back();
    }

    public function product_wip_delete(Request $req){
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $del = DB::table('products_wip')->where([["product_wip_id", $req->id], ["warehouse_id", $warehouse_id]])->delete();

        if($del){
            $req->session()->flash('success', "Product berhasil dihapus.");
        } else {
            $req->session()->flash('error', "Product gagal dihapus!");
        }

        return redirect()->back();
    }

    public function product_wip_complete(Request $req){
        $wip_id     = $req->wip_id;
        $amount     = $req->amount;
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $req->validate([
            'wip_id'    => 'required|exists:products_wip,product_wip_id',
            'amount'    => 'required|numeric',
            
        ],
        [
            'wip_id.required'   => 'WIP ID tidak ditemukan!',
            'wip_id.exists'     => 'WIP ID tidak ditemukan!',
            'amount.required'   => 'Amount belum diisi!',
            'amount.numeric'    => 'Amount harus berupa angka!',
        ]);

        $wip        = DB::table('products_wip')->select("*")->where([["product_wip_id", $wip_id], ["warehouse_id", $warehouse_id]])->first();

        if($amount <= $wip->product_amount){
            $shelf      = DB::table('shelf')->where("warehouse_id", $warehouse_id)->select("shelf_id")->first();
            if(!empty($shelf)){
                $shelf = $shelf->shelf_id;
                $wipComplete = null;

                if(count(array($wip)) > 0){
                    $data = new Request([
                        "product_id"    => $wip->product_id,
                        "name"          => $wip->customer,
                        "no_nota"       => $wip->no_nota,
                        "warehouse_id"  => $warehouse_id,
                        "amount"        => $amount,
                        "shelf"         => $shelf,
                        "type"          => 1,
                    ]);

                    $wipComplete = $this->product_stock($data);
                }

                if($wipComplete){
                    if($amount == $wip->product_amount){
                        $data = [
                            "date_out"  => date('Y-m-d H:i:s'),
                            "status"    => 1,
                        ];
                        DB::table('products_wip')->where([["product_wip_id", $wip_id], ["warehouse_id", $warehouse_id]])->update($data);
                    } else {
                        $data = [
                            "product_id"        => $wip->product_id,
                            "customer"          => $wip->customer,
                            "no_nota"           => $wip->no_nota,
                            "warehouse_id"      => $warehouse_id,
                            "product_amount"    => $amount,
                            "status"            => 1,
                        ];
                        $insertNew = DB::table('products_wip')->insertGetId($data);

                        if($insertNew){
                            $curAmount = $wip->product_amount - $amount;
                            DB::table('products_wip')->where([["product_wip_id", $wip_id], ["warehouse_id", $warehouse_id]])->update(["product_amount" => $curAmount]);
                        }
                    }
                    $req->session()->flash('success', "Product telah dipindahkan ke Products List.");
                } else {
                    $req->session()->flash('error', "Terjadi kesalahan! Mohon coba kembali!");
                }
            } else {
                $req->session()->flash('error', "Shelf belum dibuat!");
            }
        } else {
            $req->session()->flash('error', "Amount tidak tersedia!");
        }
        return redirect()->back();
    }

    public function product_wip_import(Request $req){
		$this->validate($req, [
			'file' => 'required|mimes:csv,xls,xlsx'
        ],
        [
            "file.required" => "File belum dipilih!",
            "file.mimes"    => "File harus dalam format CSV/XLS/XLSX!"
        ]);
 
		$file = $req->file('file');
 
		$filename = rand()."-".$file->getClientOriginalName();
 
		$file->move('upload/import',$filename);
 
		$import = Excel::toArray(new ProductsImport, public_path('upload/import/'.$filename));

        $data = [];
        foreach($import as $value){
            foreach($value as $v){
                $data[]=$v;
            }
        }

        $doneImport = 0;
        $countImport = count($data);
        foreach($data as $d){
            $product = DB::table('products')
                        ->where("product_code", $d["KODE PRODUK"])
                        ->first();

            if(!empty($product)){
                if(Session::has('selected_warehouse_id')){
                    $warehouse_id = Session::get('selected_warehouse_id');
                } else {
                    $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
                }

                if(empty($d['TANGGAL MASUK'])){
                    $date_in = date("Y-m-d H:i:s");
                } else {
                    $date_in = date("Y-m-d H:i:s", strtotime($d['TANGGAL MASUK']));
                }

                $param = [
                    'warehouse_id'      => $warehouse_id,
                    'product_id'        => $product->product_id,
                    'customer'          => $d['CUSTOMER'],
                    'no_nota'           => $d['NO NOTA'],
                    'product_amount'    => $d['JUMLAH'],
                    'date_in'           => $date_in,
                ];

                $add = DB::table('products_wip')->insertOrIgnore($param);

                if($add){
                    $doneImport++;
                }
            }
        }
        
        if($doneImport == $countImport){
            $req->session()->flash('success', "Semua data berhasil diimport.");
        } else {
            if($doneImport > 0){
                $req->session()->flash('success', "Sebagian data berhasil diimport.");
            } else {
                $req->session()->flash('error', "Data gagal diimport!");
            }
        }

		return redirect()->back();
    }

    public function product_stock(Request $req){
        $product_id = $req->product_id;
        $name       = $req->name;
        $no_nota    = $req->no_nota;
        $amount     = $req->amount;
        $stockDate  = $req->stock_date;
        $shelf      = $req->shelf;
        $type       = $req->type;
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }
        
        if(!empty($amount)){
            if(!empty($req->shelf)){
                $data = [
                    "user_id"           => Auth::user()->id,
                    "warehouse_id"      => $warehouse_id,
                    "product_id"        => $product_id,
                    "stock_name"        => $name,
                    "no_nota"           => $no_nota,
                    "product_amount"    => $amount,
                    "shelf_id"          => $shelf,
                    "type"              => $type,
                ];

                if(!empty($stockDate)){
                    $data["datetime"] = date("Y-m-d H:i:s", strtotime($stockDate));
                } else {
                    $data["datetime"] = date("Y-m-d H:i:s");
                }

                $totalStockIn   = DB::table('stock')->where([["warehouse_id", $warehouse_id], ["product_id", $product_id], ["shelf_id", $shelf], ["type", 1]])->sum("product_amount");
                $totalStockOut  = DB::table('stock')->where([["warehouse_id", $warehouse_id], ["product_id", $product_id], ["shelf_id", $shelf], ["type", 0]])->sum("product_amount");
                $availableStock = $totalStockIn-$totalStockOut;

                $endingTotalStockIn   = DB::table('stock')->where([["warehouse_id", $warehouse_id], ["product_id", $product_id], ["type", 1]])->sum("product_amount");
                $endingTotalStockOut  = DB::table('stock')->where([["warehouse_id", $warehouse_id], ["product_id", $product_id], ["type", 0]])->sum("product_amount");
                $endingAmount = $endingTotalStockIn-$endingTotalStockOut;

                if($type == 0){
                    if($amount > $availableStock){
                        $result = ["status" => 0, "message" => "Jumlah stock out melebihi jumlah stock yang tersedia di shelf yang dipilih!"];
                        goto resp;
                    } else {
                        $data["ending_amount"] = $endingAmount-$amount;
                    }
                } else {
                    $data["ending_amount"] = $endingAmount+$amount;
                }

                $updateStock = DB::table('stock')->insertGetId($data);

                if($updateStock){
                    $result = ["status" => 1, "message" => "Stok berhasil diupdate."];
                } else {
                    $result = ["status" => 0, "message" => "Stok gagal diupdate! Mohon coba kembali!"];
                }
            } else {
                $result = ["status" => 0, "message" => "Shelf belum dipilih!"];
            }
        } else {
            $result = ["status" => 0, "message" => "Amount belum diisi!"];
        }
        
        resp:
        return response()->json($result);
    }

    public function product_stock_history(Request $req){
        $search = $req->search;
        $dl     = $req->dl;

        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $history = DB::table('stock')
                    ->leftJoin("products", "stock.product_id", "=", "products.product_id")
                    ->leftJoin("shelf", "stock.shelf_id", "=", "shelf.shelf_id")
                    ->leftJoin("users", "stock.user_id", "=", "users.id")
                    ->select("stock.*", "products.product_code", "products.product_name", "products.satuan", "shelf.shelf_name", "users.name");

        if(!empty($search)){
            $history = $history->orWhere([["products.product_code", "LIKE", "%".$search."%"], ["products.warehouse_id", $warehouse_id]])
                        ->orWhere([["stock.stock_name", "LIKE", "%".$search."%"], ["products.warehouse_id", $warehouse_id]])
                        ->orWhere([["products.product_name", "LIKE", "%".$search."%"], ["products.warehouse_id", $warehouse_id]])
                        ->orWhere([["shelf.shelf_name", "LIKE", "%".$search."%"], ["products.warehouse_id", $warehouse_id]]);
        } else {
            $history = $history->where("products.warehouse_id", $warehouse_id);
        }

        if(!empty($dl)){
            $tmp            = $history->orderBy("stock.stock_id", "asc")->get();
            $fn             = 'history_'.time();
            $historyExport  = [];

            foreach($tmp as $t){
                if($t->type == "0"){
                    $in     = "";
                    $out    = $t->product_amount;
                    $retur  = "";
                } else if($t->type == "1"){
                    $in     = $t->product_amount;
                    $out    = "";
                    $retur  = "";
                } else {
                    $in     = "";
                    $out    = "";
                    $retur  = $t->product_amount;
                }

                $historyExport[] = [
                    "DATE"              => date('d/m/Y', strtotime($t->datetime)),
                    "PRODUCT"           => $t->product_name,
                    "NO. NOTA"          => $t->no_nota,
                    "CUSTOMER"          => $t->stock_name,
                    "STOCK IN"          => $in,
                    "STOCK OUT"         => $out,
                    "RETUR"             => $retur,
                    "SISA"              => $t->ending_amount,
                    "SATUAN (RP)"       => number_format($t->sale_price, 2, ",","."),
                ];
            }

            if($dl == "xls"){
                return (new HistoryExport($historyExport))->download($fn.'.xls', \Maatwebsite\Excel\Excel::XLS);
            } else if($dl == "pdf"){
                return (new HistoryExport($historyExport))->download($fn.'.pdf');
            }
        }

        $history = $history->orderBy("stock.stock_id", "desc")->paginate(50);

        $warehouse = $this->getWarehouse();
        return View::make("stock_history")->with(compact("history", "warehouse"));
    }

    public function categories(Request $req){
        $search = $req->q;
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $categories = DB::table('categories')->select("*");

        if(!empty($search)){
            $categories = $categories->where([["category_name", "LIKE", "%".$search."%"], ["warehouse_id", $warehouse_id]]);
        }

        if($req->format == "json"){
            $categories = $categories->where("warehouse_id", $warehouse_id)->get();

            return response()->json($categories);
        } else {
            $categories = $categories->where("warehouse_id", $warehouse_id)->paginate(50);
            $warehouse = $this->getWarehouse();
            return View::make("categories")->with(compact("categories", "warehouse"));
        }
    }

    public function categories_save(Request $req){
        $category_id = $req->category_id;
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $req->validate([
            'category_name'      => ['required']
            
        ],
        [
            'category_name.required'     => 'Nama Kategori belum diisi!',
        ]);

        $data = [
            "warehouse_id"       => $warehouse_id,
            "category_name"      => $req->category_name
        ];

        if(empty($category_id)){
            $add = DB::table('categories')->insertGetId($data);

            if($add){
                $req->session()->flash('success', "Kategori baru berhasil ditambahkan.");
            } else {
                $req->session()->flash('error', "Kategori baru gagal ditambahkan!");
            }
        } else {
            $edit = DB::table('categories')->where([["category_id", $category_id], ["warehouse_id", $warehouse_id]])->update($data);

            if($edit){
                $req->session()->flash('success', "Kategori berhasil diubah.");
            } else {
                $req->session()->flash('error', "Kategori gagal diubah!");
            }
        }
        
        return redirect()->back();
    }

    public function categories_delete(Request $req){
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $del = DB::table('categories')->where([["category_id", $req->delete_id], ["warehouse_id", $warehouse_id]])->delete();

        if($del){
            DB::table('products')->where([["category_id", $req->delete_id], ["warehouse_id", $warehouse_id]])->update(["category_id" => null]);
            $req->session()->flash('success', "Kategori berhasil dihapus.");
        } else {
            $req->session()->flash('error', "Kategori gagal dihapus!");
        }

        return redirect()->back();
    }

    public function shelf(Request $req){
        $product_id = $req->product_id;
        $shelf = DB::table('shelf');
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        if($req->format == "json"){
            if(!empty($product_id)){
                $shelf = $shelf->join("stock", "shelf.shelf_id", "stock.shelf_id")
                            ->where([["stock.product_id", $product_id], ["stock.warehouse_id", $warehouse_id]])->groupBy("shelf_id");
                $result = [];
                $shelf = $shelf->select("shelf.*", "stock.product_amount")->get();
                foreach($shelf as $s){
                    $totalStockIn   = DB::table('stock')->where([["stock.warehouse_id", $warehouse_id], ["product_id", $product_id], ["shelf_id", $s->shelf_id], ["type", 1]])->sum("product_amount");
                    $totalStockOut  = DB::table('stock')->where([["stock.warehouse_id", $warehouse_id], ["product_id", $product_id], ["shelf_id", $s->shelf_id], ["type", 0]])->sum("product_amount");
                    $availableStock = $totalStockIn-$totalStockOut;
                    if($availableStock > 0){
                        $s->product_amount = $availableStock;
                        $result[] = $s;
                    }
                }
            } else {
                $result = $shelf->select("shelf.*")->get();
            }
            return response()->json($result);
        } else {
            $shelf = $shelf->where("warehouse_id", $warehouse_id)->paginate(50);
            if(Auth::user()->role == 0){
                $warehouse = $this->getWarehouse();
                return View::make("shelf")->with(compact("shelf", "warehouse"));
            } else {
                abort(403);
            }
        }
    }

    public function shelf_save(Request $req){
        $shelf_id = $req->shelf_id;
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $req->validate([
            'shelf_name'      => ['required']
            
        ],
        [
            'shelf_name.required'     => 'Shelf Name belum diisi!',
        ]);

        $data = [
            "warehouse_id"    => $warehouse_id,
            "shelf_name"      => $req->shelf_name
        ];

        if(empty($shelf_id)){
            $add = DB::table('shelf')->insertGetId($data);

            if($add){
                $req->session()->flash('success', "Shelf baru berhasil ditambahkan.");
            } else {
                $req->session()->flash('error', "Shelf baru gagal ditambahkan!");
            }
        } else {
            $edit = DB::table('shelf')->where([["shelf_id", $shelf_id], ["warehouse_id", $warehouse_id]])->update($data);

            if($edit){
                $req->session()->flash('success', "Shelf berhasil diubah.");
            } else {
                $req->session()->flash('error', "Shelf gagal diubah!");
            }
        }
        
        return redirect()->back();
    }

    public function shelf_delete(Request $req){
        if(Session::has('selected_warehouse_id')){
            $warehouse_id = Session::get('selected_warehouse_id');
        } else {
            $warehouse_id = DB::table('warehouse')->first()->warehouse_id;
        }

        $del = DB::table('shelf')->where([["shelf_id", $req->delete_id], ["warehouse_id", $warehouse_id]])->delete();

        if($del){
            DB::table('stock')->where([["shelf_id", $req->delete_id], ["warehouse_id", $warehouse_id]])->delete();
            $req->session()->flash('success', "Shelf berhasil dihapus.");
        } else {
            $req->session()->flash('error', "Shelf gagal dihapus!");
        }

        return redirect()->back();
    }

    public function generateBarcode(Request $req){
        $code       = $req->code;
        $print      = $req->print;
        $barcodeB64 = DNS1D::getBarcodePNG("".$code."", 'C128', 2, 81, array(0,0,0), true);

        if(!empty($print) && $print == true){
            return View::make("barcode_print")->with("barcode", $barcodeB64);
        } else {
            $barcode    = base64_decode($barcodeB64);
            $image      = imagecreatefromstring($barcode);
            $barcode    = imagepng($image);
            imagedestroy($image);

            return response($barcode)->header('Content-type','image/png');
        }
    }

    public function warehouse(Request $req){
        $search = $req->q;

        $warehouse = DB::table('warehouse')->select("*");

        if(!empty($search)){
            $warehouse = $warehouse->where("username", "LIKE", "%".$search."%")
                        ->orWhere("name", "LIKE", "%".$search."%");
        }

        if($req->format == "json"){
            $warehouse = $warehouse->get();

            return response()->json($warehouse);
        } else {
            $warehouse = $warehouse->paginate(50);

            return View::make("warehouse")->with(compact("warehouse"));
        }
    }

    public function getWarehouse(){
        $warehouse = DB::table('warehouse')->select("*")->get();
        return $warehouse;
    }

    public function warehouse_select(Request $req){
        $req->validate([
            'warehouse_id'      => 'exists:warehouse,warehouse_id',
            
        ],
        [
            'warehouse_id.exists'     => 'Warehouse tidak ditemukan!',
        ]);

        $warehouse = DB::table('warehouse')->where("warehouse_id", $req->warehouse_id)->first();
        if(!empty($warehouse)){
            $req->session()->put('selected_warehouse_id', $req->warehouse_id);
            $req->session()->put('selected_warehouse_name', $warehouse->warehouse_name);
        }
        return redirect()->back();
    }

    public function warehouse_save(Request $req){
        $warehouse_id = $req->warehouse_id;

        $req->validate([
            'name'      => 'required',
            
        ],
        [
            'name.required'     => 'Fullname belum diisi!',
        ]);

        $data = [
            "warehouse_name"  => $req->name,
        ];

        if(empty($warehouse_id)){
            $add = DB::table('warehouse')->insertGetId($data);

            if($add){
                $req->session()->flash('success', "Warehouse baru berhasil ditambahkan.");
            } else {
                $req->session()->flash('error', "warehouse baru gagal ditambahkan!");
            }
        } else {
            $edit = DB::table('warehouse')->where("warehouse_id", $warehouse_id)->update($data);

            if($edit){
                $req->session()->flash('success', "Warehouse berhasil diubah.");
            } else {
                $req->session()->flash('error', "Warehouse gagal diubah!");
            }
        }
        
        return redirect()->back();
    }

    public function warehouse_delete(Request $req){
        $del = DB::table('warehouse')->where("warehouse_id", $req->delete_id)->delete();

        if($del){
            $req->session()->flash('success', "Warehouse berhasil dihapus.");
        } else {
            $req->session()->flash('error', "Warehouse gagal dihapus!");
        }

        return redirect()->back();
    }
}