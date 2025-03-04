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
Route::post('transaksi/pinjaman/list_pin', 'PinjamanController@list_pin');

Route::post('transaksi/pembayaran/get_nopin', 'PembayaranController@get_nopin');
Route::post(
    'transaksi/pembayaran/simpan_pem',
    'PembayaranController@simpan_pem'
);
Route::post('transaksi/pembayaran/list_ang', 'PembayaranController@list_ang');

Route::post('transaksi/detail_trx', 'TransaksiController@detail_trx');
Route::post('transaksi/download', 'TransaksiController@download');
Route::post('transaksi/edit_trx', 'TransaksiController@edit_trx');
Route::post('transaksi/del_trx', 'TransaksiController@del_trx');
Route::post('transaksi/send_mail', 'TransaksiController@send_mail');

Route::post('transaksi/simpanan/simpan_sim', 'SimpananController@simpan_sim');
Route::post('transaksi/simpanan/list_sim', 'SimpananController@list_sim');
Route::post('transaksi/simpanan/selectRow', 'SimpananController@selectRow');
Route::post(
    'transaksi/simpanan/sendSelected',
    'SimpananController@sendSelected'
);

Route::post('laporan/list_stock_barang', 'StockController@list_stock_barang');
Route::post('laporan/tambah_stock', 'StockController@tambah_stock');
Route::post('laporan/kurang_stock', 'StockController@kurang_stock');
Route::post('laporan/detail_bm', 'StockController@detail_bm');
Route::post('laporan/detail_bk', 'StockController@detail_bk');
Route::post('laporan/stock_excel', 'StockController@stock_excel');
Route::post('laporan/e_keluar', 'StockController@e_keluar');
Route::post('laporan/e_masuk', 'StockController@e_masuk');

Route::post('home/detail_tag', 'HomeController@detail_tag');
Route::post('chg_userProfil', 'HomeController@chg_userProfil');

Route::post('upd_id', 'HomeController@upd_id');

Route::post('laporan/rekapTransaksi', 'TelegramController@rekapTransaksi');
Route::post('laporan/manual_sendTelegram', 'TelegramController@manual_sendTelegram');

Route::post('sub/add_masterPO', 'SubController@add_masterPO');
Route::post('sub/upd_masterPO', 'SubController@upd_masterPO');
Route::post('sub/get_datasMasterPO', 'SubController@get_datasMasterPO');
Route::post('sub/l_masterPO', 'SubController@l_masterPO');
Route::post('sub/ins_dataPO', 'SubController@ins_dataPO');
Route::post('sub/l_po', 'SubController@l_po');
Route::post('sub/inq_openPo', 'SubController@inq_openPo');
Route::post('sub/upd_kirimPO', 'SubController@upd_kirimPO');
Route::post('sub/get_noDok', 'SubController@get_noDok');
Route::post('sub/inq_noDok', 'SubController@inq_noDok');

Route::post('testsend', 'TelegramController@testsend');


