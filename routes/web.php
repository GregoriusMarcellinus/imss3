<?php

use App\Http\Controllers\DetailsjnController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PurchaseRequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'indexAwal'])->name('homeAwal');
Route::get('/div/{tipe}', [App\Http\Controllers\HomeController::class, 'appType'])->name('appType');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('search');

//rute baru
Route::prefix('apps')->group(function () {
    Route::get('purchase_orders', [App\Http\Controllers\PurchaseOrderController::class, 'indexApps'])->name('apps.purchase_orders')->middleware('logistikAuth');
    Route::get('spph', [App\Http\Controllers\SpphController::class, 'indexApps'])->name('apps.spph')->middleware('logistikAuth');
    Route::get('surat_jalan', [App\Http\Controllers\SjnController::class, 'indexApps'])->name('apps.surat_jalan')->middleware('gudangAuth');
    Route::get('purchase_request', [App\Http\Controllers\PurchaseRequestController::class, 'indexApps'])->name('apps.purchase_request')->middleware('wilayahAuth');
    Route::get('surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'direksi'])->name('apps.surat_keluar.direksi');
});
Route::get('unauthorized', [App\Http\Controllers\HomeController::class, 'unauthorized'])->name('unauthorized');

Route::get('surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'index'])->name('surat_keluar.index');
Route::post('surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'create'])->name('surat_keluar.save');
Route::delete('surat-keluar', [App\Http\Controllers\SuratKeluarController::class, 'delete'])->name('surat_keluar.delete');

Route::prefix('products')->group(function () {
    Route::get('', [App\Http\Controllers\ProductController::class, 'products'])->name('products');
    Route::post('', [App\Http\Controllers\ProductController::class, 'product_save'])->name('products.save');
    Route::delete('', [App\Http\Controllers\ProductController::class, 'product_delete'])->name('products.delete')->middleware('adminRole');
    Route::get('wip', [App\Http\Controllers\ProductController::class, 'products_wip'])->name('products.wip');
    Route::post('wip', [App\Http\Controllers\ProductController::class, 'product_wip_save'])->name('products.wip.save');
    Route::delete('wip', [App\Http\Controllers\ProductController::class, 'product_wip_delete'])->name('products.wip.delete');
    Route::post('wip/complete', [App\Http\Controllers\ProductController::class, 'product_wip_complete'])->name('products.wip.complete');
    Route::get('wipHistory', [App\Http\Controllers\ProductController::class, 'products_wip_history'])->name('products.wip.history');
    Route::get('/check/{pcode}', [App\Http\Controllers\ProductController::class, 'product_check'])->name('products.check');
    Route::post('/stockUpdate', [App\Http\Controllers\ProductController::class, 'product_stock'])->name('products.stock');
    Route::get('/stockHistory', [App\Http\Controllers\ProductController::class, 'product_stock_history'])->name('products.stock.history');
    Route::get('categories', [App\Http\Controllers\ProductController::class, 'categories'])->name('products.categories');
    Route::post('categories', [App\Http\Controllers\ProductController::class, 'categories_save'])->name('products.categories.save')->middleware('adminRole');
    Route::delete('categories', [App\Http\Controllers\ProductController::class, 'categories_delete'])->name('products.categories.delete')->middleware('adminRole');
    Route::get('shelf', [App\Http\Controllers\ProductController::class, 'shelf'])->name('products.shelf');
    Route::post('shelf', [App\Http\Controllers\ProductController::class, 'shelf_save'])->name('products.shelf.save')->middleware('adminRole');
    Route::delete('shelf', [App\Http\Controllers\ProductController::class, 'shelf_delete'])->name('products.shelf.delete')->middleware('adminRole');
    Route::get('barcode/{code}', [App\Http\Controllers\ProductController::class, 'generateBarcode'])->name('products.barcode');
    Route::post('import', [App\Http\Controllers\ProductController::class, 'product_import'])->name('products.import');
    Route::post('wipImport', [App\Http\Controllers\ProductController::class, 'product_wip_import'])->name('products.wip.import');
    Route::get('sjn', [App\Http\Controllers\ProductController::class, 'sjn'])->name('sjn');
    Route::post('sjn', [App\Http\Controllers\SjnController::class, 'store'])->name('products.sjn.store');
    Route::delete('sjn', [App\Http\Controllers\SjnController::class, 'destroy'])->name('sjn.delete');
    Route::get('sjn_print', [App\Http\Controllers\ProductController::class, 'sjn_print'])->name('sjn.print');
    Route::get('po_print', [App\Http\Controllers\ProductController::class, 'po_print'])->name('po.print');
    // Route::get('pr_print', [App\Http\Controllers\PurchaseRequestController::class, 'pr_print'])->name('pr.print');
    Route::get('pr', [App\Http\Controllers\ProductController::class, 'pr'])->name('pr');
    Route::post('pr', [App\Http\Controllers\PurchaseRequestController::class, 'store'])->name('products.pr.store');
    Route::get('pr_print', [App\Http\Controllers\ProductController::class, 'pr_print'])->name('pr.print');
    Route::get('spph_print', [App\Http\Controllers\SpphController::class, 'spphPrint'])->name('spph.print');
    Route::post('upload-file', [App\Http\Controllers\PurchaseRequestController::class, 'uploadFile'])->name('upload_file');


    //keproyekan
    Route::resource('keproyekan', App\Http\Controllers\KeproyekanController::class)->except(['destroy']);
    Route::delete('keproyekan', [App\Http\Controllers\KeproyekanController::class, 'destroy'])->name('keproyekan.destroy');
    Route::delete('/stockHistory', [App\Http\Controllers\ProductController::class, 'product_stock_history_delete'])->name('products.stock.history.delete');

    //detail sjn
    Route::get('detail_sjn/{id}', [App\Http\Controllers\SjnController::class, 'getDetailSjn'])->name('detail_sjn');
    Route::get('cetak_sjn', [App\Http\Controllers\SjnController::class, 'cetakSjn'])->name('cetak_sjn');
    Route::post('update_detail_sjn', [App\Http\Controllers\SjnController::class, 'updateDetailSjn'])->name('detail_sjn.update');

    //vendor
    Route::resource('vendor', App\Http\Controllers\VendorController::class)->except(['destroy']);
    Route::delete('vendor', [App\Http\Controllers\VendorController::class, 'destroy'])->name('vendor.destroy');

    //purchase order
    Route::resource('purchase_order', App\Http\Controllers\PurchaseOrderController::class)->except(['destroy']);
    Route::get('cetak_po', [App\Http\Controllers\PurchaseOrderController::class, 'cetakPo'])->name('cetak_po');
    Route::post('detail_po_save', [App\Http\Controllers\PurchaseOrderController::class, 'detailPrSave'])->name('detail_po_save');
    Route::delete('detail_po_delete', [App\Http\Controllers\PurchaseOrderController::class, 'destroyDetailPo'])->name('detail_po_delete'); //baru delete detail po
    Route::post('detail_pr_save', [App\Http\Controllers\PurchaseRequestController::class, 'detailPrSave'])->name('detail_pr_save');
    Route::post('tambah_detail_po', [App\Http\Controllers\PurchaseOrderController::class, 'tambahDetailPo'])->name('tambah_detail_po');
    Route::get('tracking', [App\Http\Controllers\PurchaseOrderController::class, 'tracking'])->name('product.tracking');
    Route::get('trackingwil', [App\Http\Controllers\PurchaseOrderController::class, 'trackingwil'])->name('product.trackingwil');
    Route::get('showPOPL', [App\Http\Controllers\PurchaseOrderController::class, 'showPOPL'])->name('product.showPOPL');
    Route::get('approvedPO', [App\Http\Controllers\PurchaseOrderController::class, 'aprrovedPO'])->name('product.approvedPO');
    Route::get('aprrovedPO_PL', [App\Http\Controllers\PurchaseOrderController::class, 'aprrovedPO_PL'])->name('product.aprrovedPO_PL');
    Route::post('storePOPL', [App\Http\Controllers\PurchaseOrderController::class, 'storePOPL'])->name('product.storePOPL');


    Route::get('test_pr', [App\Http\Controllers\PurchaseOrderController::class, 'test_pr'])->name('test_pr');

    //justifikasi
    Route::get('justifikasi', [App\Http\Controllers\JustifikasiController::class, 'index'])->name('product.justifikasi');
    Route::post('justifikasi', [App\Http\Controllers\JustifikasiController::class, 'store'])->name('product.justifikasi.save');
    Route::delete('justifikasi', [App\Http\Controllers\JustifikasiController::class, 'destroy'])->name('product.justifikasi.delete');

    //drawing schematic
    Route::get('drawing-schematic', [App\Http\Controllers\DrawingSchematicController::class, 'index'])->name('product.drawing.schematic');
    Route::post('drawing-schematic', [App\Http\Controllers\DrawingSchematicController::class, 'store'])->name('product.drawing.schematic.save');
    Route::delete('drawing-schematic', [App\Http\Controllers\DrawingSchematicController::class, 'destroy'])->name('product.drawing.schematic.delete');

    //purchase request
    Route::resource('purchase_request', App\Http\Controllers\PurchaseRequestController::class)->except(['destroy']);
    Route::get('cetak_pr', [App\Http\Controllers\PurchaseRequestController::class, 'cetakPr'])->name('cetak_pr');
    Route::delete('purchase_request', [App\Http\Controllers\PurchaseRequestController::class, 'destroy'])->name('purchase_request.destroy');
    Route::get('purchase_request_detail/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'getDetailPr'])->name('purchase_request_detail');
    Route::post('update_purchase_request_detail', [App\Http\Controllers\PurchaseRequestController::class, 'updateDetailPr'])->name('purchase_request_detail.update');

    //history
    Route::get('/history', [HistoryController::class, 'index']);
    Route::delete('/history', [HistoryController::class, 'deleteAll'])->name('history.delete');
    Route::delete('purchase_order', [App\Http\Controllers\PurchaseOrderController::class, 'destroy'])->name('purchase_order.destroy');
    Route::get('purchase_order_detail/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'getDetailPo'])->name('purchase_order_detail');
    Route::post('update_purchase_order_detail', [App\Http\Controllers\PurchaseOrderController::class, 'updateDetailPo'])->name('purchase_order_detail.update');

    //PO_PL
    Route::get("purchase_order_pl", [App\Http\Controllers\PurchaseOrderController::class, 'getDetailPoPL'])->name('purchase_order_pl');
    // Route::post("purchase_order_pl", [App\Http\Controllers\PurchaseOrderController::class, 'storeDetailPoPL'])->name('purchase_order_pl.store');
    Route::delete('delete_po_pl', [App\Http\Controllers\PurchaseOrderController::class, 'destroyPoPL'])->name('purchase_order_pl.destroy');

    //kode material
    Route::resource('kode_material', App\Http\Controllers\KodeMaterialController::class)->except(['destroy']);
    Route::delete('kode_material', [App\Http\Controllers\KodeMaterialController::class, 'destroy'])->name('kode_material.destroy');

    //SPPH
    Route::resource('spph', App\Http\Controllers\SpphController::class)->except(['destroy']);
    Route::delete('spph', [App\Http\Controllers\SpphController::class, 'destroy'])->name('spph.destroy');
    Route::get('spph_detail/{id}', [App\Http\Controllers\SpphController::class, 'getDetailSpph'])->name('spph_detail');
    Route::post('update_spph_detail', [App\Http\Controllers\SpphController::class, 'updateDetailSpph'])->name('spph_detail.update');
    Route::get('products_pr', [App\Http\Controllers\SpphController::class, 'getProductPR'])->name('products_pr');
    Route::post('tambah_spph_detail', [App\Http\Controllers\SpphController::class, 'tambahSpphDetail'])->name('tambah_spph_detail');

    //logistik
    Route::get('logistik', [App\Http\Controllers\LogistikController::class, 'index'])->name('products.logistik');

    // engineering edit pr
    Route::get('showEditPr', [App\Http\Controllers\PurchaseRequestController::class, 'showEditPr'])->name('eng.purchase_request');
    Route::post('edit_purchase_request', [App\Http\Controllers\PurchaseRequestController::class, 'editPrEng'])->name('edit_purchase_request');
});

Route::prefix('users')->group(function () {
    Route::get('', [App\Http\Controllers\UserController::class, 'users'])->name('users')->middleware('adminRole');
    Route::delete('', [App\Http\Controllers\UserController::class, 'user_delete'])->name('users.delete')->middleware('adminRole');
    Route::post('', [App\Http\Controllers\UserController::class, 'user_save'])->name('users.save')->middleware('adminRole');
});

Route::prefix('warehouse')->group(function () {
    Route::get('', [App\Http\Controllers\ProductController::class, 'warehouse'])->name('warehouse')->middleware('adminRole');
    Route::delete('', [App\Http\Controllers\ProductController::class, 'warehouse_delete'])->name('warehouse.delete')->middleware('adminRole');
    Route::post('', [App\Http\Controllers\ProductController::class, 'warehouse_save'])->name('warehouse.save')->middleware('adminRole');
    Route::get('change/{warehouse_id}', [App\Http\Controllers\ProductController::class, 'warehouse_select'])->name('warehouse.select');
});

Route::prefix('account')->group(function () {
    Route::get('', [App\Http\Controllers\UserController::class, 'myaccount'])->name('myaccount');
    Route::post('profile', [App\Http\Controllers\UserController::class, 'myaccount_update'])->name('myaccount.update');
    Route::post('password', [App\Http\Controllers\UserController::class, 'myaccount_update_password'])->name('myaccount.updatePassword');
});


Route::get('test_sheet', [App\Http\Controllers\SheetController::class, 'getDataSheet'])->name('test_sheet');
Route::get('get_sheets', [App\Http\Controllers\SheetController::class, 'getDataSheet'])->name('get_sheets');
Route::get('sync_sheets', [App\Http\Controllers\SheetController::class, 'sync'])->name('sync_sheets');
Route::get('test_komat', [App\Http\Controllers\SheetController::class, 'test_komat'])->name('test_komat');
Route::get('materials', [App\Http\Controllers\KodeMaterialController::class, 'apiKodeMaterial'])->name('komat');

Route::get('pdf_lain', [App\Http\Controllers\PdfController::class, 'pdf_lain'])->name('pdf_lain');

Route::get('testt', function () {
    echo Hash::make('admin123');
});

Route::get('voucher', function () {
    return view('keuangan.voucher');
})->name('voucher');
Route::get('ppk', function () {
    return view('keuangan.ppk');
});

Route::get('penerimaan-barang', [App\Http\Controllers\PurchaseRequestController::class, 'penerimaan_barang'])->name('penerimaan-barang');
