<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\AnggotaModel;

class MasterController extends Controller
{
    public function frm_anggota()
    {
        return view('master/frm_anggota');
    }

    public function list_anggota(Request $request)
    {
        //dd($request->all());
        $test = Auth::user()->name;
        //dd($test);
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');
        $Datas = DB::table('tb_anggota')->get();
        $count = DB::table('tb_anggota')->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function tambah_anggota(Request $request)
    {
        //dd($request->all());
        //$test = Auth('api')->user();
        $test = Auth::user()->name;
        dd($test);
        $idAnggota = Str::uuid();
        $insert_anggota = AnggotaModel::create([
            'id_anggota' => $idAnggota,
            'nama' => $request->ta_nama,
            'nik' => $request->ta_nik,
            'alamat' => $request->ta_alamat,
            'no_telp' => $request->ta_notelp,
            'no_ktp' => $request->ta_noktp,
            'status' => 'Aktif',
        ]);

        return [
            'message' => 'Tambah Anggota Berhasil .',
            'success' => true,
        ];
    }
}
