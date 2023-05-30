<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
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
        //dd($request->all());
        $cb = Carbon::now();
        $tahun = $cb->format('Ym');

        $leng = DB::select(
            'select length(no_pinjaman)as panjang from tb_pinjaman WHERE no_pinjaman in (SELECT max(no_pinjaman)FROM tb_pinjaman) '
        );
        $cek = DB::select(
            'SELECT substring(no_pinjaman,-4)as terakhir FROM tb_pinjaman WHERE no_pinjaman in (SELECT max(no_pinjaman)FROM tb_pinjaman) '
        );
        //dd($cek[0]->terakhir);

        if (empty($leng)) {
            $no_pinjaman = 'P' . $tahun . '1001';
        } elseif ($cek[0]->terakhir == 9999) {
            $no_pinjaman = 'P' . $tahun . '1001';
        } else {
            $no_pinjaman = 'P' . ($tahun . $cek[0]->terakhir + 1);
        }

        //dd($cek[0]->terakhir + 1);

        $nik = AnggotaModel::select('nik')
            ->where('no_barcode', $request->pin_nobarcode)
            ->get();

        if ($request->role == 'Administrator') {
            $ins_pin = PinjamanModel::create([
                'id_pinjaman' => str::uuid(),
                'no_pinjaman' => $no_pinjaman,
                'nik' => $nik[0]->nik,
                'no_anggota' => $request->pin_nobarcode,
                'nama' => $request->pin_nama,
                'jml_pinjaman' => $request->pin_jmlpin,
                'tgl_realisasi' => $request->pin_tglreal,
                'tenor' => $request->pin_tenor,
                'status_pinjaman' => 'Open',
            ]);

            return [
                'message' => 'Input Pinjaman Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Input Pinjaman Gagal .',
                'success' => false,
            ];
        }
    }

    public function list_pin(Request $request)
    {
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');
        $Datas = DB::table('tb_pinjaman')
            ->select('no_pinjaman', 'nama', 'jml_pinjaman', 'tenor')
            ->where('status_pinjaman', '=', 'Open')
            ->where(function ($q) use ($search) {
                $q
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('no_pinjaman', 'like', '%' . $search . '%');
            })
            ->groupBy('no_pinjaman', 'nama', 'jml_pinjaman', 'tenor')
            ->orderBy('no_pinjaman', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_pinjaman')
            ->select('no_pinjaman', 'nama', 'jml_pinjaman', 'tenor')
            ->where('status_pinjaman', '=', 'Open')
            ->where(function ($q) use ($search) {
                $q
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('no_pinjaman', 'like', '%' . $search . '%');
            })
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }
}
