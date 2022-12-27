<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PinjamanController extends Controller
{
    public function frm_pinjaman()
    {
        return view('transaksi/frm_pinjaman');
    }
}
