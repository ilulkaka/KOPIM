<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function frm_barang()
    {
        return view('master/barang');
    }
}
