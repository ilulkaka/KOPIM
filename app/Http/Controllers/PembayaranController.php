<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\AnggotaModel;
use App\Models\PinjamanModel;
use App\Models\PembayaranModel;

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
        /*$ang = PembayaranModel::select('angsuran_ke')
            ->where('no_pinjaman', $nopin)
            ->where(
                'angsuran_ke',
                \DB::raw("(select max('angsuran_ke')from tb_pembayaran)")
            )
            ->get();*/

        $ang = DB::select(
            'select length(angsuran_ke)as angsuran_ke from tb_pembayaran WHERE angsuran_ke in (SELECT max(angsuran_ke)FROM tb_pembayaran) '
        );

        if (empty($ang)) {
            $ke = 0;
        } else {
            $ke = $ang[0]->angsuran_ke;
        }

        if (count($datas) > 0) {
            return [
                'message' => 'get detail pinjaman .',
                'success' => true,
                'datas' => $datas,
                'angsuran_ke' => $ke,
            ];
        } else {
            return [
                'message' => 'Nomer pinjaman tidak ada .',
                'success' => false,
            ];
        }
    }
}
