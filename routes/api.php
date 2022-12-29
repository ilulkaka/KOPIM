<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware(['auth:sanctum', 'abilities:admin'])->group(function () {});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/home', function (Request $request) {
        return auth()->user();
    });
});
Route::post('master/tambah_anggota', 'MasterController@tambah_anggota');
Route::post('master/edit_anggota', 'MasterController@edit_anggota');
Route::post('master/hapus_anggota', 'MasterController@hapus_anggota');
Route::post('master/list_anggota', 'MasterController@list_anggota');

Route::post('master/tambah_pengguna', 'MasterController@tambah_pengguna');
Route::post('master/edit_pengguna', 'MasterController@edit_pengguna');
Route::post('master/list_pengguna', 'MasterController@list_pengguna');
Route::post('master/tambah_barang', 'MasterController@tambah_barang');
Route::post('master/edit_barang', 'MasterController@edit_barang');
Route::post('master/list_barang', 'MasterController@list_barang');

Route::post('transaksi/get_barcode', 'TransaksiController@get_barcode');
Route::post('transaksi/trx_simpan', 'TransaksiController@trx_simpan');
Route::post('transaksi/pinjaman/simpan_pin', 'PinjamanController@simpan_pin');

Route::post('transaksi/detail_trx', 'TransaksiController@detail_trx');
Route::post('transaksi/download', 'TransaksiController@download');

Route::post('laporan/list_stock_barang', 'StockController@list_stock_barang');
Route::post('laporan/tambah_stock', 'StockController@tambah_stock');
Route::post('laporan/kurang_stock', 'StockController@kurang_stock');
Route::post('laporan/detail_bm', 'StockController@detail_bm');
Route::post('laporan/detail_bk', 'StockController@detail_bk');
Route::post('laporan/stock_excel', 'StockController@stock_excel');

Route::post('home/detail_tag', 'HomeController@detail_tag');
