<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
                    'a.kode, a.nama, a.spesifikasi, a.supplier, sum(coalesce(b.qty_in,0))as qty_in, sum(coalesce(c.qty_out,0))as qty_out, coalesce((sum(b.qty_in)) - (sum(c.qty_out)),0) as stock '
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
            ->get();*/

        $co = DB::select(
            "SELECT a.kode, a.nama, a.spesifikasi, a.supplier, COALESCE(b.qty_in,0)as qty_in, COALESCE(c.qty_out,0)as qty_out, coalesce((b.qty_in) - (c.qty_out),0) as stock FROM
                (SELECT * FROM tb_barang)a 
                LEFT JOIN
                (SELECT kode, sum(qty_in)as qty_in FROM tb_in GROUP BY kode)b on b.kode=a.kode
                LEFT JOIN
                (SELECT kode, sum(qty_out)as qty_out FROM tb_out GROUP BY kode)c on c.kode=a.kode
                where (a.kode like '%$search%' or a.nama like '%$search%')
                LIMIT  $length OFFSET $start  "
        );

        $count = count($co);

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
        } else {
            return [
                'message' => 'Access tidak diperbolehkan .',
                'success' => false,
            ];
        }
    }
}
