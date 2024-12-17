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
            "select max(angsuran_ke)as angsuran_ke from tb_pembayaran where no_pinjaman='$nopin'"
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

    public function simpan_pem(Request $request)
    {
        // dd($request->all());
        if ($request->role == 'Administrator') {
            if ($request->pem_angke == $request->pem_tenor) {
                $st = 'Close';
            } else {
                $st = 'Open';
            }

            $ins_pin = PembayaranModel::create([
                'id_pembayaran' => str::uuid(),
                'no_pinjaman' => $request->pem_nopin,
                'no_anggota' => $request->pem_nobarcode,
                'nama' => $request->pem_nama,
                'jml_angsuran' => $request->pem_jmlang,
                'tgl_angsuran' => $request->pem_perang,
                'angsuran_ke' => $request->pem_angke,
                'status_angsuran' => $st,
                'type_angsuran' => $request->f_type,
            ]);

            if ($request->pem_angke == $request->pem_tenor) {
                $upd_pin = PinjamanModel::where(
                    'no_pinjaman',
                    $request->pem_nopin
                )->update([
                    'status_pinjaman' => 'Close',
                ]);
                return [
                    'message' => 'Angsuran Lunas . . .',
                    'success' => true,
                ];
            }

            return [
                'message' => 'Input Angsuran Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Input Angsuran Gagal .',
                'success' => false,
            ];
        }
    }

    public function list_ang(Request $request)
    {
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $f_status = $request->f_status;
        
        $arrStatus = '';
        if ($f_status == 'All') {
            $arrStatus = "status_angsuran IN ('Open', 'Close')"; 
        } else {
            $arrStatus = "status_angsuran = '$f_status'"; 
        }
        

        $Datas = DB::select("
        WITH RankedData AS (
        SELECT no_pinjaman, nama, jml_angsuran, angsuran_ke, status_angsuran,
            ROW_NUMBER() OVER (PARTITION BY no_pinjaman ORDER BY angsuran_ke DESC) AS row_num
        FROM tb_pembayaran
        )
        SELECT no_pinjaman, nama, jml_angsuran, angsuran_ke, status_angsuran
        FROM RankedData
        WHERE row_num = 1 and $arrStatus and (no_pinjaman like '%$search%' or nama like '%$search%') LIMIT $length OFFSET $start");

        $co = DB::select(
            "WITH RankedData AS (
        SELECT no_pinjaman, nama, jml_angsuran, angsuran_ke, status_angsuran,
            ROW_NUMBER() OVER (PARTITION BY no_pinjaman ORDER BY angsuran_ke DESC) AS row_num
        FROM tb_pembayaran
        )
        SELECT no_pinjaman, nama, jml_angsuran, angsuran_ke, status_angsuran
        FROM RankedData
        WHERE row_num = 1 and $arrStatus and (no_pinjaman like '%$search%' or nama like '%$search%')");
        $count = count($co);

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }
}
