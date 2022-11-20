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
    Route::post('master/list_anggota', 'MasterController@list_anggota');
    Route::get('master/frm_pengguna', 'MasterController@frm_pengguna');
    Route::post('master/list_pengguna', 'MasterController@list_pengguna');

    Route::get('transaksi/belanja', 'TransaksiController@belanja');
});
