<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\AnggotaModel;
use App\Models\BelanjaModel;
use Carbon\Carbon;
use App\Models\User;

class TransaksiController extends Controller
{
    public function belanja()
    {
        return view('transaksi/belanja');
    }

    public function get_barcode(Request $request)
    {
        //dd($request->all());
        $no_barcode = $request->input('no_barcode');
        $cek_anggota = DB::table('tb_anggota')
            ->select('nama')
            ->where('no_barcode', $no_barcode)
            ->get();

        if (count($cek_anggota) == 0) {
            return [
                'message' => 'Record tidak ditemukan .',
                'success' => false,
            ];
        } else {
            return [
                'message' => 'success',
                'success' => true,
                'nama' => $cek_anggota[0]->nama,
            ];
        }
    }

    public function trx_simpan(Request $request)
    {
        //dd($request->all());
        $kategori = $request->input('trx_kategori');
        $idTrx = Str::uuid();
        if ($kategori == 'Anggota') {
            $insert_trx = BelanjaModel::create([
                'id_trx_belanja' => $idTrx,
                'tgl_trx' => date('Y-m-d'),
                'nama' => $request->trx_nama,
                'nominal' => $request->trx_nominal,
                'no_barcode' => $request->trx_nobarcode,
                'kategori' => $kategori,
                'inputor' => $request->role,
            ]);
        } else {
            $insert_trx = BelanjaModel::create([
                'id_trx_belanja' => $idTrx,
                'tgl_trx' => date('Y-m-d'),
                'nama' => $request->trx_nama,
                'nominal' => $request->trx_nominal,
                'no_barcode' => $request->trx_nobarcode1,
                'kategori' => $kategori,
                'inputor' => $request->role,
            ]);
        }

        if ($insert_trx) {
            return [
                'message' => 'Transaksi Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Input Gagal .',
                'success' => false,
            ];
        }
    }
}
