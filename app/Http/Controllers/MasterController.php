<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        dd($request->all());
    }
}
