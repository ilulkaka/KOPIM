<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\AnggotaModel;

class SimpananController extends Controller
{
    public function frm_simpanan()
    {
        $no_anggota = AnggotaModel::where('status', '=', 'Aktif')->get();
        return view('transaksi/frm_simpanan', [
            'no_anggota' => $no_anggota,
        ]);
    }
}
