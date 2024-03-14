<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\AnggotaModel;
use App\Models\BelanjaModel;
use Carbon\Carbon;
use App\Models\User;

class TransaksiController extends Controller
{
    public function belanja()
    {
        $tgl_sekarang = date('Y-m-d');
        $hasil_anggota = DB::select(
            "select sum(nominal)as nominal from tb_trx_belanja where tgl_trx = '$tgl_sekarang' and kategori = 'Anggota'"
        );
        $hasil_umum = DB::select(
            "select sum(nominal)as nominal from tb_trx_belanja where tgl_trx = '$tgl_sekarang' and kategori = 'Umum'"
        );
        $hasil_total = $hasil_anggota[0]->nominal + $hasil_umum[0]->nominal;
        //dd($hasil_anggota[0]->nominal);
        return view('transaksi/belanja', [
            'hasil_anggota' => $hasil_anggota[0],
            'hasil_umum' => $hasil_umum[0],
            'hasil_total' => $hasil_total,
        ]);
    }

    public function get_barcode(Request $request)
    {
        // dd($request->all());
        $no_barcode1 = $request->input('no_barcode');
        if (strlen($no_barcode1) < 16) {
            return [
                'message' => 'Record salah .',
                'success' => false,
            ];
        } else {
            $no_barcode = substr($no_barcode1, 16); // mengambil data id_anggota
        }

        $cek_anggota = DB::table('tb_anggota')
            ->select('id_anggota', 'no_barcode', 'nik', 'nama')
            // ->where('no_barcode', $no_barcode)
            ->where('id_anggota', $no_barcode)
            ->where('status', '=', 'Aktif')
            ->get();

        if (count($cek_anggota) == 0) {
            return [
                'message' => 'Record tidak ditemukan .',
                'success' => false,
            ];
        } else {
            return [
                'message' => 'success',
                'success' => true,
                'nama' => $cek_anggota[0]->nama,
                'nik' => $cek_anggota[0]->nik,
            ];
        }
    }

    public function trx_simpan(Request $request)
    {
        // dd($request->all());
        $id_anggota = substr($request->trx_nobarcode, 16);
        $datas = DB::table('tb_anggota')
            ->select('id_anggota', 'no_barcode', 'nik', 'nama')
            ->where('id_anggota', $id_anggota)
            ->where('status', '=', 'Aktif')
            ->get();

        $kategori = $request->input('trx_kategori');
        if ($kategori == 'Anggota') {
            $no_barcode = $datas[0]->no_barcode;
        } else {
            $no_barcode = '999999';
        }

        if ($request->role1 == 'Administrator') {
            $date_trx = $request->tgl_trx;
        } else {
            $date_trx = date('Y-m-d');
        }

        $idTrx = Str::uuid();
        $insert_trx = BelanjaModel::create([
            'id_trx_belanja' => $idTrx,
            'tgl_trx' => $date_trx,
            'nama' => $datas[0]->nama,
            'nominal' => $request->trx_nominal,
            'no_barcode' => $no_barcode,
            'nik' => $datas[0]->nik,
            'kategori' => $kategori,
            'inputor' => $request->role,
        ]);

        if ($insert_trx) {
            return [
                'message' => 'Update Berhasil !',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Gagal Update request !',
                'success' => false,
            ];
        }
    }

    public function detail_trx(Request $request)
    {
        //dd($request->all());
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;
        $Datas = DB::table('tb_trx_belanja')
            ->where('tgl_trx', '>=', $tgl_awal)
            ->where('tgl_trx', '<=', $tgl_akhir)
            ->where(function ($q) use ($search) {
                $q
                    ->where('no_barcode', 'like', '%' . $search . '%')
                    ->orwhere('nama', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_trx_belanja')
            ->where('tgl_trx', '>=', $tgl_awal)
            ->where('tgl_trx', '<=', $tgl_akhir)
            ->where(function ($q) use ($search) {
                $q
                    ->where('no_barcode', 'like', '%' . $search . '%')
                    ->orwhere('nama', 'like', '%' . $search . '%');
            })
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function download(Request $request)
    {
        //dd($request->all());
        $Datas = DB::select(
            "select no_barcode, nik, nama, sum(nominal)as nominal, kategori from tb_trx_belanja where tgl_trx >= '$request->tgl_awal' and tgl_trx <='$request->tgl_akhir' group by no_barcode, nik, nama, kategori order by nik "
        );

        if (count($Datas) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'No Barcode');
            $sheet->setCellValue('C1', 'NIK');
            $sheet->setCellValue('D1', 'NAMA');
            $sheet->setCellValue('E1', 'Nominal');
            $sheet->setCellValue('F1', 'Kategori');

            $line = 2;
            $no = 1;
            foreach ($Datas as $data) {
                $sheet->setCellValue('A' . $line, $no++);
                $sheet->setCellValue('B' . $line, $data->no_barcode);
                $sheet->setCellValue('C' . $line, $data->nik);
                $sheet->setCellValue('D' . $line, $data->nama);
                $sheet->setCellValue('E' . $line, $data->nominal);
                $sheet->setCellValue('F' . $line, $data->kategori);

                $line++;
            }

            // ========= Online ========================================
            // $writer = new Xlsx($spreadsheet);
            // $filename = 'Transaksi_' . date('YmdHis') . '.xlsx';
            // //dd('/home/berkahma/public_html/storage/excel/' . $filename);

            // $writer->save(
            //     '/home/berkahma/public_html/storage/excel/' . $filename
            // );
            // return ['file' => url('/') . '/storage/excel/' . $filename];

            // ========= Offline ========================================
            $writer = new Xlsx($spreadsheet);
            $filename = 'Transaksi.xlsx';
            $writer->save(public_path('storage/excel/' . $filename));
            return ['file' => url('/') . '/storage/excel/' . $filename];
        } else {
            return ['message' => 'No Data .', 'success' => false];
        }
    }

    public function edit_trx(Request $request)
    {
        // dd($request->all());
        $findid = BelanjaModel::find($request->et_id);

        if ($request->role == 'Administrator') {
            $findid->nominal = $request->et_nominal;

            $findid->save();

            return [
                'message' => 'Edit data Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Edit gagal, Access Denied .',
                'success' => false,
            ];
        }
    }

    public function del_trx(Request $request)
    {
        // dd($request->all());
        $findid = BelanjaModel::find($request->id_trx);

        if ($request->role == 'Administrator') {
            $findid->delete();

            return [
                'message' => 'Hapus data Trx Berhasil .',
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
