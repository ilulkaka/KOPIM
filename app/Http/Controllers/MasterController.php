<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\AnggotaModel;
use Carbon\Carbon;
use App\Models\User;

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
        $Datas = DB::table('tb_anggota')
            ->where(function ($q) use ($search) {
                $q
                    ->where('no_barcode', 'like', '%' . $search . '%')
                    ->orwhere('nik', 'like', '%' . $search . '%')
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            })
            ->orderBy('no_barcode', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_anggota')
            ->where(function ($q) use ($search) {
                $q
                    ->where('no_barcode', 'like', '%' . $search . '%')
                    ->orwhere('nik', 'like', '%' . $search . '%')
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            })
            ->count();

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
        $cb = Carbon::now();
        $tahun = $cb->format('Ym');
        $cek = DB::select(
            'SELECT substring(no_barcode,-4)as terakhir FROM tb_anggota WHERE no_barcode in (SELECT max(no_barcode)FROM tb_anggota) '
        );
        $no_barcode = $tahun . $cek[0]->terakhir + 1;

        $idAnggota = Str::uuid();
        $insert_anggota = AnggotaModel::create([
            'id_anggota' => $idAnggota,
            'nama' => $request->ta_nama,
            'nik' => $request->ta_nik,
            'alamat' => $request->ta_alamat,
            'no_telp' => $request->ta_notelp,
            'no_ktp' => $request->ta_noktp,
            'status' => 'Aktif',
            'no_barcode' => $no_barcode,
        ]);

        return [
            'message' => 'Tambah Anggota Berhasil .',
            'success' => true,
        ];
    }

    public function edit_anggota(Request $request)
    {
        $findid = AnggotaModel::find($request->ea_id_anggota);

        if ($request->role == 'Administrator') {
            $findid->nik = $request->ea_nik;
            $findid->nama = $request->ea_nama;
            $findid->no_ktp = $request->ea_noktp;
            $findid->no_telp = $request->ea_notelp;
            $findid->alamat = $request->ea_alamat;
            $findid->status = $request->ea_status;

            $findid->save();

            return [
                'message' => 'Edit data Anggota Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Edit gagal, Access Denied .',
                'success' => false,
            ];
        }
    }

    public function hapus_anggota(Request $request)
    {
        $findid = AnggotaModel::find($request->ha_id_anggota);

        if ($request->role == 'Staff') {
            $findid->delete();

            return [
                'message' => 'Hapus data Anggota Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Hapus gagal, Access Denied .',
                'success' => false,
            ];
        }
    }
}
