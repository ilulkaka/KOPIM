<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\AnggotaModel;
use App\Models\SimpananModel;

class SimpananController extends Controller
{
    public function frm_simpanan()
    {
        $no_anggota = AnggotaModel::where('status', '=', 'Aktif')->get();
        return view('transaksi/frm_simpanan', [
            'no_anggota' => $no_anggota,
        ]);
    }

    public function simpan_sim(Request $request)
    {
        //dd($request->all());
        $namaanggota = AnggotaModel::select('nama')
            ->where('no_barcode', $request->sim_nomer)
            ->get();

        if ($request->role == 'Administrator') {
            $ins_sim = SimpananModel::create([
                'id_simpanan' => str::uuid(),
                'no_anggota' => $request->sim_nomer,
                'nama' => $namaanggota[0]->nama,
                'jml_simpanan' => $request->sim_jml,
                'tgl_simpan' => $request->sim_tgl,
                'jenis_simpanan' => $request->sim_jenis,
                'status_simpanan' => 'Open',
            ]);

            return [
                'message' => 'Input Simpanan Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Input Simpanan Gagal .',
                'success' => false,
            ];
        }
    }

    public function list_sim(Request $request)
    {
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');
        $Datas = DB::table('tb_simpanan')
            ->select(
                'nama',
                DB::raw('sum(jml_simpanan)as jml_simpanan'),
                'jenis_simpanan'
            )
            ->where('status_simpanan', '=', 'Open')
            ->where(function ($q) use ($search) {
                $q
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('jenis_simpanan', 'like', '%' . $search . '%');
            })
            ->groupBy('nama', 'jenis_simpanan')
            //->orderBy('no_pinjaman', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_simpanan')
            ->select(
                'nama',
                DB::raw('sum(jml_simpanan)as jml_simpanan'),
                'jenis_simpanan'
            )
            ->where('status_simpanan', '=', 'Open')
            ->where(function ($q) use ($search) {
                $q
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('jenis_simpanan', 'like', '%' . $search . '%');
            })
            //->groupBy('nama', 'jenis_simpanan')
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }
}
