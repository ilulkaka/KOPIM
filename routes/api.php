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
    Route::post('master/tambah_anggota', 'MasterController@tambah_anggota');
});
