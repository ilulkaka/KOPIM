<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\AnggotaModel;
use App\Models\PinjamanModel;

class PinjamanController extends Controller
{
    public function frm_pinjaman()
    {
        $no = AnggotaModel::where('status', '=', 'Aktif')->get();
        return view('transaksi/frm_pinjaman', ['no' => $no]);
    }

    public function simpan_pin(Request $request)
    {
        dd($request->all());
        $nik = AnggotaModel::select('nik')
            ->where('no_barcode', $request->pin_nobarcode)
            ->get();

        if ($request->role == 'Administrator') {
            $ins_pin = PinjamanModel::create([
                'id_pinjaman' => str::uuid(),
                'no_pinjaman' => $t,
                'nik' => $er,
            ]);
        }
    }
}
