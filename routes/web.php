<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Route::post('/webhook', function () {
//     \Log::info($request->all());
//     return response()->json(['status' => 'success'], 200);
// });

// Route::get('/getUpdates', 'TransaksiController@getUpdates');
Route::post('/webhook', 'TransaksiController@handleWebhook');

Route::get('/', 'LoginController@login')->name('login');
Route::post('loginaksi', 'LoginController@loginaksi')->name('loginaksi');
/*Route::get('home', 'HomeController@index')
    ->name('home')
    ->middleware('auth');
Route::get('logoutaksi', 'LoginController@logoutaksi')
    ->name('logoutaksi')
    ->middleware('auth');

Route::get('master/frm_anggota', 'MasterController@frm_anggota');
*/
Route::middleware('auth')->group(function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('userProfil', 'HomeController@userProfil');
    Route::get('logoutaksi', 'LoginController@logoutaksi')->name('logoutaksi');

    Route::get('master/frm_anggota', 'MasterController@frm_anggota');
    Route::get('master/frm_pengguna', 'MasterController@frm_pengguna');
    Route::get('master/frm_barang', 'MasterController@frm_barang');
    Route::post('master/frm_printQR', 'MasterController@frm_printQR');

    Route::get('transaksi/belanja', 'TransaksiController@belanja')->name(
        'transaksi'
    );
    Route::get('transaksi/frm_pinjaman', 'PinjamanController@frm_pinjaman');

    Route::get(
        'transaksi/frm_pembayaran',
        'PembayaranController@frm_pembayaran'
    );

    Route::get('transaksi/frm_simpanan', 'SimpananController@frm_simpanan');

    Route::get('laporan/stock_barang', 'StockController@stock_barang');
    Route::get('laporan/barang_masuk', 'StockController@barang_masuk');
    Route::get('laporan/barang_keluar', 'StockController@barang_keluar');

    Route::get('sub/frm_po', 'SubController@frm_po');
    Route::get('sub/frm_master_po', 'SubController@frm_master_po');
    Route::get('sub/inq_po', 'SubController@inq_po');
    Route::get('sub/inq_dok', 'SubController@inq_dok');

    // Route::get('send-wa', function(){
    //     $response = Http::withHeaders([
    //         'Authorization' => 'LMjyNNhxuSK8pDpa4Z9n',
    //     ])->post('https://api.fonnte.com/send',[
    //         'target' => '085746200098',
    //         'message' => 'Ini pesan laravel',
    //     ]);

    // });


    Route::get('laporan/frm_sendTelegram', 'TelegramController@frm_sendTelegram');
    Route::get('laporan/lap_transaksi', 'TelegramController@lap_transaksi');

    Route::get('sub/cetak_sj/{doDok}', 'SubController@cetak_sj');
    Route::get('sub/cetak_inv/{doDok}', 'SubController@cetak_inv');
});
