<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\BelanjaModel;
use App\Models\PinjamanModel;
use App\Models\PembayaranModel;
use Carbon\Carbon;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $nama = Auth::user()->name;
        $nik = Auth::user()->nik;

        $nobarcode = DB::select(
            "select id_anggota, no_barcode from tb_anggota where nik='$nik' and status='Aktif'"
        );

        if (empty($nobarcode)) {
            $nobarcode1 = 0;
            $idAnggota = 0;
        } else {
            $nobarcode1 = $nobarcode[0]->no_barcode;
            $idAnggota = $nobarcode[0]->id_anggota;
        }
        //dd($nobarcode1);

        $current = Carbon::now();
        $tgl = date('d');
        $tmb_bulan = $current->addMonth();
        $krg_bulan = Carbon::now()->subMonths(1);
        $thn = date('Y');
        $bulan = date('Y-m');

        $tgl_awal = date('Y-m') . '-01';
        $tgl_akhir = date('Y-m') . '-25';
        //dd($tmb_bulan);
        if ($tgl <= 25) {
            $per_awal = $krg_bulan->format('Y-m') . '-16';
            $per_akhir = date('Y-m') . '-15';

            $aktif = DB::select(
                "select sum(nominal)as nominal from tb_trx_belanja where no_barcode = '$nobarcode1' and tgl_trx >= '$per_awal' and tgl_trx <= '$per_akhir'"
            );
        } else {
            $per_awal2 = date('Y-m') . '-16';
            $per_akhir2 = $tmb_bulan->format('Y-m') . '-15';

            $aktif = DB::select(
                "select sum(nominal)as nominal from tb_trx_belanja where no_barcode = '$nobarcode1' and tgl_trx >= '$per_awal2' and tgl_trx <= '$per_akhir2'"
            );
        }

        $nopin = DB::select(
            "select no_pinjaman from tb_pinjaman where no_anggota = '$nobarcode1' and status_pinjaman = 'Open'"
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
            "select jml_angsuran, angsuran_ke from tb_pembayaran where no_pinjaman='$nom' and tgl_angsuran >= '$tgl_awal' and tgl_angsuran <= '$tgl_akhir'"
        );

        if (empty($ang)) {
            $jml_ang = '0';
            $angke = '0';
        } else {
            $jml_ang = $ang[0]->jml_angsuran;
            $angke = $ang[0]->angsuran_ke;
        }

        $simpok = DB::select(
            "select sum(jml_simpanan)as simpok from tb_simpanan where no_anggota = '$nobarcode1' and jenis_simpanan = 'Pokok'"
        );

        $simwa = DB::select(
            "select sum(jml_simpanan)as simwa from tb_simpanan where no_anggota = '$nobarcode1' and jenis_simpanan = 'Wajib'"
        );

        $iuran_wajib = DB::select(
            " select jml_simpanan from tb_simpanan where no_anggota = '$nobarcode1' and jenis_simpanan = 'Wajib' and date_format(tgl_simpan, '%Y-%m') = '$bulan' "
        );

        if (empty($iuran_wajib)) {
            $iuran = '0';
        } else {
            $iuran = $iuran_wajib[0]->jml_simpanan;
        }
        //dd($iuran_wajib[0]->jml_simpanan);

        $qrCode = QrCode::size(350)->generate($idAnggota);

        return view('home', [
            'thn' => $thn,
            'aktif' => $aktif,
            'angsuran' => $jml_ang,
            'angke' => $angke,
            'no_barcode' => $nobarcode1,
            'simpok' => $simpok[0]->simpok,
            'simwa' => $simwa[0]->simwa,
            'iuran' => $iuran,
            'qrCode' => $qrCode,
        ]);
        //return view('/dashboard/javascript');
    }

    public function detail_tag(Request $request)
    {
        //dd($request->all());
        $nik = $request->nik;

        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $Datas = BelanjaModel::select('tgl_trx', 'nominal')
            ->where('no_barcode', $request->no_barcode)
            ->where('tgl_trx', '>=', $request->tgl_awal)
            ->where('tgl_trx', '<=', $request->tgl_akhir)
            ->orderBy('tgl_trx', 'asc')
            ->skip($start)
            ->take($length)
            ->get();
        $count = BelanjaModel::select('tgl_trx', 'nominal')
            ->where('no_barcode', $request->no_barcode)
            ->where('tgl_trx', '>=', $request->tgl_awal)
            ->where('tgl_trx', '<=', $request->tgl_akhir)
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
        /*
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
        }*/
    }

    public function userProfil(Request $request)
    {
        return view('userProfil');
    }

    public function chg_userProfil(Request $request)
    {
        //dd($request->all());
        $findid = User::find($request->id_user);

        $findid->password = Hash::make($request->p_baru);

        $findid->save();

        return [
            'message' => 'Berhasil ganti password .',
            'success' => true,
        ];
    }

    // public function upd_id(Request $request)
    // {
    //     // dd($request->all());
    //     $upd = DB::table('tb_anggota')
    //         ->whereRaw('LENGTH(id_anggota) < 3')
    //         ->get();

    //     foreach ($upd as $row) {
    //         $newUuid = \Illuminate\Support\Str::uuid()->toString();

    //         DB::table('tb_anggota')
    //             ->where('id_anggota', $row->id_anggota)
    //             ->update([
    //                 'id_anggota' => $newUuid,
    //             ]);
    //     }
    // }
}
