<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'LoginController@login')->name('login');
Route::post('loginaksi', 'LoginController@loginaksi')->name('loginaksi');
Route::get('home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('logoutaksi', 'LoginController@logoutaksi')->name('logoutaksi')->middleware('auth');