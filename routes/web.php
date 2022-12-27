<?php

use Illuminate\Support\Facades\Route;

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
    Route::get('logoutaksi', 'LoginController@logoutaksi')->name('logoutaksi');

    Route::get('master/frm_anggota', 'MasterController@frm_anggota');
    Route::get('master/frm_pengguna', 'MasterController@frm_pengguna');
    Route::get('master/frm_barang', 'MasterController@frm_barang');

    Route::get('transaksi/belanja', 'TransaksiController@belanja');
    Route::get('transaksi/frm_pinjaman', 'PinjamanController@frm_pinjaman');

    Route::get('laporan/stock_barang', 'StockController@stock_barang');
    Route::get('laporan/barang_masuk', 'StockController@barang_masuk');
    Route::get('laporan/barang_keluar', 'StockController@barang_keluar');
});
