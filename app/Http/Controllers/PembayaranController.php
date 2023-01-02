<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\AnggotaModel;
use App\Models\PinjamanModel;

class PembayaranController extends Controller
{
    public function frm_pembayaran()
    {
        $no_pin = PinjamanModel::select('no_pinjaman')
            ->where('status_pinjaman', '=', 'Open')
            ->get();
        return view('transaksi/frm_pembayaran', ['no_pin' => $no_pin]);
    }

    public function get_nopin(Request $request)
    {
        //dd($request->all());
        $nopin = $request->nopin;
        $datas = PinjamanModel::where('no_pinjaman', $nopin)
            ->where('status_pinjaman', '=', 'Open')
            ->get();
    }
}
