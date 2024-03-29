<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\AnggotaModel;
use App\Models\BarangModel;
use Carbon\Carbon;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class MasterController extends Controller
{
    public function frm_anggota()
    {
        $anggota = DB::table('tb_anggota')
            ->select('id_anggota', 'no_barcode', 'nik', 'nama')
            ->get();

        return view('master/frm_anggota', ['anggota' => $anggota]);
    }

    public function frm_printQR(Request $request)
    {
        // dd($request->all());
        $pq_anggota = $request->input('pq_anggota');
        // dd($pq_anggota[0]);
        if ($pq_anggota[0] == 'All') {
            $anggota = DB::table('tb_anggota')
                ->select('id_anggota', 'no_barcode')
                ->where('status', '=', 'Aktif')
                ->get();
        } else {
            $anggota = DB::table('tb_anggota')
                ->select('id_anggota', 'nama', 'no_barcode')
                ->whereIn('id_anggota', $pq_anggota)
                ->where('status', '=', 'Aktif')
                ->get();
        }
        // dd($test);

        $id_anggota = [];

        foreach ($anggota as $ang) {
            array_push($id_anggota, $ang->id_anggota);
        }
        // dd($id_anggota);
        // $qrCode = QrCode::size(75)->generate($id_anggota);
        $qrCodes = []; // Inisialisasi array kosong untuk menyimpan QR codes

        foreach ($id_anggota as $id) {
            $qrCode = QrCode::size(75)->generate('kopim.kopbm.com/' . $id);
            $qrCodes[] = $qrCode;
        }

        // dd($qrCodes);

        return view('master/print_qr', [
            'anggota' => $anggota,
            'qrCodes' => $qrCodes,
        ]);
    }

    public function list_anggota(Request $request)
    {
        //dd($request->all());
        //$test = Auth::user()->name;
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

        $leng = DB::select(
            'select length(no_barcode)as panjang from tb_anggota WHERE no_barcode in (SELECT max(no_barcode)FROM tb_anggota) '
        );
        $cek = DB::select(
            'SELECT substring(no_barcode,-4)as terakhir FROM tb_anggota WHERE no_barcode in (SELECT max(no_barcode)FROM tb_anggota) '
        );
        //dd($cek[0]->terakhir);

        if ($leng[0]->panjang == 0) {
            $no_barcode = $tahun . '1001';
        } elseif ($cek[0]->terakhir == 9999) {
            $no_barcode = $tahun . '1001';
        } else {
            $no_barcode = $tahun . $cek[0]->terakhir + 1;
        }

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

        if ($request->role == 'Administrator') {
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

    // ========================== PENGGUNA =================================================

    public function frm_pengguna()
    {
        return view('master/frm_pengguna');
    }

    public function list_pengguna(Request $request)
    {
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');
        $Datas = DB::table('users')
            ->where('name', '!=', 'Admin')
            ->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', '%' . $search . '%')
                    ->orwhere('email', 'like', '%' . $search . '%')
                    ->orwhere('role', 'like', '%' . $search . '%');
            })
            ->orderBy('name', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('users')
            ->where('name', '!=', 'Admin')
            ->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', '%' . $search . '%')
                    ->orwhere('email', 'like', '%' . $search . '%')
                    ->orwhere('role', 'like', '%' . $search . '%');
            })
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function tambah_pengguna(Request $request)
    {
        //dd($request->all());
        $cek = DB::table('users')
            ->select('email')
            ->where('email', $request->tp_email)
            ->count();
        $nik = DB::table('users')
            ->select('nik')
            ->where('nik', $request->tp_nik)
            ->count();

        if ($request->role == 'Administrator') {
            if ($cek >= 1 || $nik >= 1) {
                return [
                    'message' => 'NIK atau Email sudah ada .',
                    'success' => false,
                ];
            } else {
                $idPengguna = Str::uuid();
                $insert_pengguna = User::create([
                    'id' => $idPengguna,
                    'nik' => $request->tp_nik,
                    'name' => $request->tp_nama,
                    'email' => $request->tp_email,
                    'role' => $request->tp_level,
                    'status' => 'Aktif',
                    'password' => Hash::make($request->tp_password),
                    //'remember_token' => $insert_pengguna->createToken(
                    //    'auth_token'
                    //)->plainTextToken,
                ]);
                return [
                    'message' => 'Tambah data Pengguna baru Berhasil .',
                    'success' => true,
                ];
            }
        } else {
            return [
                'message' => 'Level ini tidak bisa tambah Pengguna baru .',
                'success' => false,
            ];
        }
    }

    public function edit_pengguna(Request $request)
    {
        //dd($request->all());
        $findid = User::find($request->ep_id_pengguna);

        if ($request->role == 'Administrator') {
            $findid->password = Hash::make($request->ep_password);
            $findid->role = $request->ep_level;
            $findid->status = $request->ep_status;
            $findid->save();

            return [
                'message' => 'Edit data Pengguna Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Edit gagal, Level tidak diperbolehkan .',
                'success' => false,
            ];
        }
    }

    //================================== BARANG ---------------------------------------------------

    public function frm_barang()
    {
        return view('master/frm_barang');
    }

    public function tambah_barang(Request $request)
    {
        //dd($request->all());
        $cek = DB::table('tb_barang')
            ->select('kode')
            ->where('kode', $request->tb_kode)
            ->count();

        if ($cek <= 0) {
            $idbarang = Str::uuid();
            $insert_barang = BarangModel::create([
                'id_barang' => $idbarang,
                'kode' => $request->tb_kode,
                'nama' => $request->tb_nama,
                'spesifikasi' => $request->tb_spesifikasi,
                'supplier' => $request->tb_supplier,
                'harga' => $request->tb_harga,
            ]);

            return [
                'message' => 'Tambah data Barang Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Kode barang sudah ada .',
                'success' => false,
            ];
        }
    }

    public function list_barang(Request $request)
    {
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');
        $Datas = DB::table('tb_barang')
            ->where(function ($q) use ($search) {
                $q
                    ->where('kode', 'like', '%' . $search . '%')
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orwhere('supplier', 'like', '%' . $search . '%')
                    ->orwhere('spesifikasi', 'like', '%' . $search . '%');
            })
            ->orderBy('kode', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_barang')
            ->where(function ($q) use ($search) {
                $q
                    ->where('kode', 'like', '%' . $search . '%')
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orwhere('supplier', 'like', '%' . $search . '%')
                    ->orwhere('spesifikasi', 'like', '%' . $search . '%');
            })
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function edit_barang(Request $request)
    {
        //dd($request->all());
        $findid = BarangModel::find($request->eb_id_barang);

        if ($request->role == 'Administrator') {
            $findid->spesifikasi = $request->eb_spesifikasi;
            $findid->harga = $request->eb_harga;

            $findid->save();

            return [
                'message' => 'Edit data Barang Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Edit gagal, Level tidak diperbolehkan .',
                'success' => false,
            ];
        }
    }
}
