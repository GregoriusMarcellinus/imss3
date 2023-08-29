<?php

use App\Http\Controllers\DetailsjnController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/search', [App\Http\Controllers\ProductController::class, 'search'])->name('search');
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

    //purchase
    Route::resource('purchase_order', App\Http\Controllers\PurchaseOrderController::class)->except(['destroy']);

    //history
    Route::get('/history', [HistoryController::class, 'index']);
    Route::delete('/history', [HistoryController::class, 'deleteAll'])->name('history.delete');
    Route::delete('purchase_order', [App\Http\Controllers\PurchaseOrderController::class, 'destroy'])->name('purchase_order.destroy');
    Route::get('purchase_order_detail/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'getDetailPo'])->name('purchase_order_detail');
    Route::post('update_purchase_order_detail', [App\Http\Controllers\PurchaseOrderController::class, 'updateDetailPo'])->name('purchase_order_detail.update');

    //kode material
    Route::resource('kode_material', App\Http\Controllers\KodeMaterialController::class)->except(['destroy']);
    Route::delete('kode_material', [App\Http\Controllers\KodeMaterialController::class, 'destroy'])->name('kode_material.destroy');
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
