<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\InModel;
use App\Models\OutModel;

class StockController extends Controller
{
    public function stock_barang()
    {
        return view('laporan/list_stock');
    }

    public function list_stock_barang(Request $request)
    {
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $Datas = DB::select(
            "SELECT a.kode, a.nama, a.spesifikasi, a.supplier, COALESCE(b.qty_in,0)as qty_in, COALESCE(c.qty_out,0)as qty_out, coalesce((b.qty_in) - ifnull(c.qty_out,0),0) as stock FROM
             (SELECT * FROM tb_barang)a
             LEFT JOIN
             (SELECT kode, sum(qty_in)as qty_in FROM tb_in GROUP BY kode)b on b.kode=a.kode
             LEFT JOIN
             (SELECT kode, sum(qty_out)as qty_out FROM tb_out GROUP BY kode)c on c.kode=a.kode
             where (a.kode like '%$search%' or a.nama like '%$search%')
             LIMIT  $length OFFSET $start  "
        );

        /*$Datas = DB::table('tb_barang as a')
            ->leftJoin('tb_in as b', 'b.kode', '=', 'a.kode')
            ->leftJoin('tb_out as c', 'c.kode', '=', 'a.kode')
            ->select(
                DB::raw(
                    'a.kode, a.nama, a.spesifikasi, a.supplier, sum(coalesce(b.qty_in,0))as qty_in, sum(coalesce(c.qty_out,0))as qty_out, (sum(coalesce(b.qty_in,0)) - sum(coalesce(c.qty_out,0))) as stock '
                )
            )
            ->where(function ($q) use ($search) {
                $q
                    ->where('a.kode', 'like', '%' . $search . '%')
                    ->orwhere('a.nama', 'like', '%' . $search . '%')
                    ->orwhere('a.spesifikasi', 'like', '%' . $search . '%')
                    ->orwhere('a.supplier', 'like', '%' . $search . '%');
            })
            ->groupBy(
                'a.kode',
                'a.nama',
                'a.spesifikasi',
                'a.supplier',
                'b.kode',
                'c.kode'
            )
            ->skip($start)
            ->take($length)
            ->get();*/

        $count = DB::table('tb_barang as a')
            ->leftJoin('tb_in as b', 'b.kode', '=', 'a.kode')
            ->leftJoin('tb_out as c', 'c.kode', '=', 'a.kode')
            ->select(
                DB::raw(
                    'a.kode, a.nama, a.spesifikasi, a.supplier, sum(coalesce(b.qty_in,0))as qty_in, sum(coalesce(c.qty_out,0))as qty_out, (sum(coalesce(b.qty_in,0)) - sum(coalesce(c.qty_out,0))) as stock '
                )
            )
            ->where(function ($q) use ($search) {
                $q
                    ->where('a.kode', 'like', '%' . $search . '%')
                    ->orwhere('a.nama', 'like', '%' . $search . '%')
                    ->orwhere('a.spesifikasi', 'like', '%' . $search . '%')
                    ->orwhere('a.supplier', 'like', '%' . $search . '%');
            })
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function tambah_stock(Request $request)
    {
        if ($request->role == 'Administrator' || $request->role == 'Kasir') {
            $idin = Str::uuid();
            $tambah_stock = InModel::create([
                'id_in' => $idin,
                'kode' => $request->ts_kode,
                'tgl_in' => $request->ts_tglmsk,
                'qty_in' => $request->ts_qty,
            ]);
            return [
                'message' => 'Tambah Stock Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Access tidak diperbolehkan .',
                'success' => false,
            ];
        }
    }

    public function kurang_stock(Request $request)
    {
        //dd($request->all());
        if ($request->role == 'Administrator' || $request->role == 'Kasir') {
            if ($request->input('ks_qty') > $request->input('ks_stock')) {
                return [
                    'message' => 'Qty out lebih besar dari Stock .',
                    'success' => false,
                ];
            } else {
                $idout = Str::uuid();
                $kurang_stock = OutModel::create([
                    'id_out' => $idout,
                    'kode' => $request->ks_kode,
                    'tgl_out' => $request->ks_tglklr,
                    'qty_out' => $request->ks_qty,
                ]);
                return [
                    'message' => 'Kurang Stock Berhasil .',
                    'success' => true,
                ];
            }
        } else {
            return [
                'message' => 'Access tidak diperbolehkan .',
                'success' => false,
            ];
        }
    }

    public function barang_masuk()
    {
        return view('laporan/barang_masuk');
    }

    public function detail_bm(Request $request)
    {
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

        $Datas = DB::select(
            "SELECT a.tgl_in, a.kode, b.nama, b.spesifikasi, b.supplier, COALESCE(a.qty_in,0)as qty_in FROM
            (SELECT * FROM tb_in where tgl_in >= '$tgl_awal' and tgl_in <= '$tgl_akhir')a 
            LEFT JOIN
            (SELECT kode, nama, spesifikasi, supplier FROM tb_barang)b on b.kode=a.kode
            where (a.kode like '%$search%' or b.nama like '%$search%' or b.spesifikasi like '%$search%'or b.supplier like '%$search%')
            LIMIT  $length OFFSET $start  "
        );

        $co = DB::select(
            "SELECT a.tgl_in, a.kode, b.nama, b.spesifikasi, b.supplier, COALESCE(a.qty_in,0)as qty_in FROM
            (SELECT * FROM tb_in where tgl_in >= '$tgl_awal' and tgl_in <= '$tgl_akhir')a 
            LEFT JOIN
            (SELECT kode, nama, spesifikasi, supplier FROM tb_barang)b on b.kode=a.kode
            where (a.kode like '%$search%' or b.nama like '%$search%' or b.spesifikasi like '%$search%'or b.supplier like '%$search%') "
        );
        $count = count($co);

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function barang_keluar()
    {
        return view('laporan/barang_keluar');
    }

    public function detail_bk(Request $request)
    {
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

        $Datas = DB::select(
            "SELECT a.tgl_out, a.kode, b.nama, b.spesifikasi, b.supplier, COALESCE(a.qty_out,0)as qty_out FROM
            (SELECT * FROM tb_out where tgl_out >= '$tgl_awal' and tgl_out <= '$tgl_akhir')a 
            LEFT JOIN
            (SELECT kode, nama, spesifikasi, supplier FROM tb_barang)b on b.kode=a.kode
            where (a.kode like '%$search%' or b.nama like '%$search%' or b.spesifikasi like '%$search%'or b.supplier like '%$search%')
            LIMIT  $length OFFSET $start  "
        );

        $co = DB::select(
            "SELECT a.tgl_out, a.kode, b.nama, b.spesifikasi, b.supplier, COALESCE(a.qty_out,0)as qty_out FROM
            (SELECT * FROM tb_out where tgl_out >= '$tgl_awal' and tgl_out <= '$tgl_akhir')a 
            LEFT JOIN
            (SELECT kode, nama, spesifikasi, supplier FROM tb_barang)b on b.kode=a.kode
                where (a.kode like '%$search%' or b.nama like '%$search%' or b.spesifikasi like '%$search%'or b.supplier like '%$search%')  "
        );

        $count = count($co);

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function stock_excel(Request $request)
    {
        $Datas = DB::select(
            "SELECT a.kode, a.nama, a.spesifikasi, a.supplier, COALESCE(b.qty_in,0)as qty_in, COALESCE(c.qty_out,0)as qty_out, coalesce((b.qty_in) - ifnull(c.qty_out,0),0) as stock FROM
            (SELECT * FROM tb_barang)a 
            LEFT JOIN
            (SELECT kode, sum(qty_in)as qty_in FROM tb_in GROUP BY kode)b on b.kode=a.kode
            LEFT JOIN
            (SELECT kode, sum(qty_out)as qty_out FROM tb_out GROUP BY kode)c on c.kode=a.kode"
        );

        if (count($Datas) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'KODE');
            $sheet->setCellValue('C1', 'NAMA');
            $sheet->setCellValue('D1', 'Spesifikasi');
            $sheet->setCellValue('E1', 'Stock');

            $line = 2;
            $no = 1;
            foreach ($Datas as $data) {
                $sheet->setCellValue('A' . $line, $no++);
                $sheet->setCellValue('B' . $line, $data->kode);
                $sheet->setCellValue('C' . $line, $data->nama);
                $sheet->setCellValue('D' . $line, $data->spesifikasi);
                $sheet->setCellValue('E' . $line, $data->stock);

                $line++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'List_Stock.xlsx';
            $writer->save(public_path('storage/excel/' . $filename));
            return ['file' => url('/') . '/storage/excel/' . $filename];
        } else {
            return ['message' => 'No Data .', 'success' => false];
        }
    }

    public function e_keluar(Request $request)
    {
        // dd($request->all());
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

        $Datas = DB::select(
            "SELECT a.tgl_out, a.kode, b.nama, b.spesifikasi, b.supplier, COALESCE(a.qty_out,0)as qty_out FROM
            (SELECT * FROM tb_out where tgl_out >= '$tgl_awal' and tgl_out <= '$tgl_akhir')a 
            LEFT JOIN
            (SELECT kode, nama, spesifikasi, supplier FROM tb_barang)b on b.kode=a.kode"
        );

        if (count($Datas) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'KODE');
            $sheet->setCellValue('C1', 'NAMA');
            $sheet->setCellValue('D1', 'Spesifikasi');
            $sheet->setCellValue('E1', 'Qty Out');
            $sheet->setCellValue('F1', 'Tgl Out');

            $line = 2;
            $no = 1;
            foreach ($Datas as $data) {
                $sheet->setCellValue('A' . $line, $no++);
                $sheet->setCellValue('B' . $line, $data->kode);
                $sheet->setCellValue('C' . $line, $data->nama);
                $sheet->setCellValue('D' . $line, $data->spesifikasi);
                $sheet->setCellValue('E' . $line, $data->qty_out);
                $sheet->setCellValue('F' . $line, $data->tgl_out);

                $line++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'List_Out.xlsx';
            $writer->save(public_path('storage/excel/' . $filename));
            return ['file' => url('/') . '/storage/excel/' . $filename];
        } else {
            return ['message' => 'No Data .', 'success' => false];
        }
    }

    public function e_masuk(Request $request)
    {
        // dd($request->all());
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');

        $Datas = DB::select(
            "SELECT a.tgl_in, a.kode, b.nama, b.spesifikasi, b.supplier, COALESCE(a.qty_in,0)as qty_in FROM
            (SELECT * FROM tb_in where tgl_in >= '$tgl_awal' and tgl_in <= '$tgl_akhir')a 
            LEFT JOIN
            (SELECT kode, nama, spesifikasi, supplier FROM tb_barang)b on b.kode=a.kode"
        );

        if (count($Datas) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'No');
            $sheet->setCellValue('B1', 'KODE');
            $sheet->setCellValue('C1', 'NAMA');
            $sheet->setCellValue('D1', 'Spesifikasi');
            $sheet->setCellValue('E1', 'Qty In');
            $sheet->setCellValue('F1', 'Tgl In');

            $line = 2;
            $no = 1;
            foreach ($Datas as $data) {
                $sheet->setCellValue('A' . $line, $no++);
                $sheet->setCellValue('B' . $line, $data->kode);
                $sheet->setCellValue('C' . $line, $data->nama);
                $sheet->setCellValue('D' . $line, $data->spesifikasi);
                $sheet->setCellValue('E' . $line, $data->qty_in);
                $sheet->setCellValue('F' . $line, $data->tgl_in);

                $line++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'List_masuk.xlsx';
            $writer->save(public_path('storage/excel/' . $filename));
            return ['file' => url('/') . '/storage/excel/' . $filename];
        } else {
            return ['message' => 'No Data .', 'success' => false];
        }
    }
}
