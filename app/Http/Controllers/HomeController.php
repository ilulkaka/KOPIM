<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\BelanjaModel;
use App\Models\PinjamanModel;
use App\Models\PembayaranModel;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $nama = Auth::user()->name;
        $nik = Auth::user()->nik;

        $current = Carbon::now();
        $tgl = date('d');
        $tmb_bulan = $current->addMonth();
        $krg_bulan = Carbon::now()->subMonths(1);
        $thn = date('Y');

        $tgl_awal = date('Y-m') . '-01';
        $tgl_akhir = date('Y-m') . '-25';
        //dd($tmb_bulan);
        if ($tgl <= 15) {
            $per_awal = $krg_bulan->format('Y-m') . '-16';
            $per_akhir = date('Y-m') . '-15';
            /*$aktif = BelanjaModel::select(DB::raw('sum(nominal)as nominal'))
                ->where('nik', $nik)
                ->where('tgl_trx', '>=', $per_awal)
                ->where('tgl_trx', '<=', $per_akhir)
                ->get();*/

            $aktif = DB::select(
                "select sum(nominal)as nominal from tb_trx_belanja where nik = '$nik' and tgl_trx >= '$per_awal' and tgl_trx <= '$per_akhir'"
            );
        } else {
            $per_awal2 = date('Y-m') . '-16';
            $per_akhir2 = $tmb_bulan->format('Y-m') . '-15';
            /*$aktif = BelanjaModel::select(DB::raw('sum(nominal)as nominal'))
                ->where('nik', $nik)
                ->where('tgl_trx', '>=', $per_awal2)
                ->where('tgl_trx', '<=', $per_akhir2)
                ->get();*/

            $aktif = DB::select(
                "select sum(nominal)as nominal from tb_trx_belanja where nik = '$nik' and tgl_trx >= '$per_awal2' and tgl_trx <= '$per_akhir2'"
            );
        }

        /*$nopin = PinjamanModel::select('no_pinjaman')
            ->where('nik', '=', $nik)
            ->where('status_pinjaman', '=', 'Open')
            ->get();*/
        $nopin = DB::select(
            "select no_pinjaman from tb_pinjaman where nik = '$nik' and status_pinjaman = 'Open'"
        );

        if (empty($nopin)) {
            $nom = '0';
        } else {
            $nom = $nopin[0]->no_pinjaman;
        }

        /*$ang = PembayaranModel::select('jml_angsuran')
            ->where('no_pinjaman', $nom)
            ->where('tgl_angsuran', '>=', $per_awal)
            ->where('tgl_angsuran', '<=', $per_akhir)
            ->get();*/

        $ang = DB::select(
            "select jml_angsuran from tb_pembayaran where no_pinjaman='$nom' and tgl_angsuran >= '$tgl_awal' and tgl_angsuran <= '$tgl_akhir'"
        );

        if (empty($ang)) {
            $angke = '0';
        } else {
            $angke = $ang[0]->jml_angsuran;
        }

        return view('home', [
            'thn' => $thn,
            'aktif' => $aktif,
            'angsuran' => $angke,
        ]);
        //return view('/dashboard/javascript');
    }

    public function detail_tag(Request $request)
    {
        $nik = $request->nik;

        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $current = Carbon::now();
        $tgl = date('d');
        $tmb_bulan = $current->addMonth();
        $krg_bulan = Carbon::now()->subMonths(1);
        $thn = date('Y');

        if ($tgl <= 15) {
            $per_awal = $krg_bulan->format('Y-m') . '-16';
            $per_akhir = date('Y-m') . '-15';
            $Datas = BelanjaModel::select('tgl_trx', 'nominal')
                ->where('nik', $nik)
                ->where('tgl_trx', '>=', $per_awal)
                ->where('tgl_trx', '<=', $per_akhir)
                ->orderBy('tgl_trx', 'asc')
                ->skip($start)
                ->take($length)
                ->get();
            $count = BelanjaModel::select('tgl_trx', 'nominal')
                ->where('nik', $nik)
                ->where('tgl_trx', '>=', $per_awal)
                ->where('tgl_trx', '<=', $per_akhir)
                ->count();

            return [
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $Datas,
            ];
        } else {
            $per_awal = date('Y-m') . '-16';
            $per_akhir = $tmb_bulan->format('Y-m') . '-15';
            $Datas = BelanjaModel::select('tgl_trx', 'nominal')
                ->where('nik', $nik)
                ->where('tgl_trx', '>=', $per_awal)
                ->where('tgl_trx', '<=', $per_akhir)
                ->orderBy('tgl_trx', 'asc')
                ->skip($start)
                ->take($length)
                ->get();

            $count = BelanjaModel::select('tgl_trx', 'nominal')
                ->where('nik', $nik)
                ->where('tgl_trx', '>=', $per_awal)
                ->where('tgl_trx', '<=', $per_akhir)
                ->count();

            return [
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $Datas,
            ];
        }
    }
}
