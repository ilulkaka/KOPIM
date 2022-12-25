<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\BelanjaModel;
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
        //dd($tmb_bulan);
        if ($tgl <= 15) {
            $per_awal = $krg_bulan->format('Y-m') . '-16';
            $per_akhir = date('Y-m') . '-15';
            $aktif = BelanjaModel::select(DB::raw('sum(nominal)as nominal'))
                ->where('nik', $nik)
                ->where('tgl_trx', '>=', $per_awal)
                ->where('tgl_trx', '<=', $per_akhir)
                ->get();
        } else {
            $per_awal = date('Y-m') . '-16';
            $per_akhir = $tmb_bulan->format('Y-m') . '-15';
            $aktif = BelanjaModel::select(DB::raw('sum(nominal)as nominal'))
                ->where('nik', $nik)
                ->where('tgl_trx', '>=', $per_awal)
                ->where('tgl_trx', '<=', $per_akhir)
                ->get();
        }

        return view('home', [
            'thn' => $thn,
            'aktif' => $aktif[0]->nominal,
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
