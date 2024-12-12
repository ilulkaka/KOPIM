<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\MasterPOModel;
use App\Models\POModel;

class SubController extends Controller
{
    public function frm_po (){
        return view ('sub/frm_po');
    }

    public function frm_master_po (){
        return view ('sub/frm_master_po');
    }

    public function add_masterPO (Request $request){
        // dd($request->all());

        $cek = DB::table('tb_master_po')
            ->select('item_cd')
            ->where('item_cd', $request->tmpo_itemCd)
            ->count();

        if ($cek <= 0) {
            $idMasterPO = Str::uuid();
            $ins_masterPO = MasterPOModel::create([
                'id_master_po' => $idMasterPO,
                'item_cd' => $request->tmpo_itemCd,
                'nama' => $request->tmpo_nama,
                'spesifikasi' => $request->tmpo_spesifikasi,
                'satuan' => $request->tmpo_uom,
                'harga' => $request->tmpo_harga,
            ]);

            return [
                'message' => 'Tambah data Master PO Berhasil .',
                'success' => true,
            ];
        } else {
            return [
                'message' => 'Item Cd sudah ada .',
                'success' => false,
            ];
        }
    }

    public function l_masterPO (Request $request){
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');
        $Datas = DB::table('tb_master_po')
            ->where(function ($q) use ($search) {
                $q
                    ->where('item_cd', 'like', '%' . $search . '%')
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orwhere('spesifikasi', 'like', '%' . $search . '%');
            })
            ->orderBy('item_cd', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_master_po')
        ->where(function ($q) use ($search) {
            $q
                ->where('item_cd', 'like', '%' . $search . '%')
                ->orwhere('nama', 'like', '%' . $search . '%')
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

    public function upd_masterPO (Request $request){
        //  dd($request->all());
         $findid = MasterPOModel::find($request->empo_id);

         if ($request->role == 'Administrator') {
            $findid->nama = $request->empo_nama;
             $findid->spesifikasi = $request->empo_spesifikasi;
             $findid->harga = $request->empo_harga;
             $findid->satuan = $request->empo_satuan;
 
             $findid->save();
 
             return [
                 'message' => 'Edit Master PO Berhasil .',
                 'success' => true,
             ];
         } else {
             return [
                 'message' => 'Edit gagal, Level tidak diperbolehkan .',
                 'success' => false,
             ];
         }
    }

    public function get_datasMasterPO (Request $request){
        // dd($request->all());
        $getDatas = DB::table('tb_master_po')->where('item_cd',$request->datas)->first();

        if(!$getDatas){
            return [
                'success' => false,
                'message' => 'Item Cd tidak ada .',
            ];
        } else {
            return[
                'success' => true,
                'datas' => $getDatas,
            ];
        }
    }

    public function ins_dataPO (Request $request){
        // dd($request->all());

        $getDatas = DB::table('tb_master_po')->where('item_cd',$request->itemCd)->first();

        $ins = POModel::create([
            'id_po' => str::uuid(),
            'tgl_po' => date('Y-m-d'),
            'nomor_po' => $request->nopo,
            'item_cd' => $request->itemCd,
            'nama' => $getDatas->nama,
            'spesifikasi' => $getDatas->spesifikasi,
            'qty' => $request->qty,
            'satuan' => $getDatas->satuan,
            'harga' => $getDatas->harga,
            'nouki' => $request->nouki,
            'status_po' => 'Open',
        ]);

        if ($ins){
            return [
                'success' => true,
                'message' => 'Insert data berhasil .',
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Insert data gagal .',
            ];
        }
    }

    public function l_po (Request $request){
        // dd($request->all());
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $po_no = $request->no_po;

        $Datas = DB::table('tb_po')->where('nomor_po',$po_no)
            ->where(function ($q) use ($search) {
                $q
                    ->where('item_cd', 'like', '%' . $search . '%')
                    ->orwhere('nomor_po', 'like', '%' . $search . '%')
                    ->orwhere('nama', 'like', '%' . $search . '%')
                    ->orwhere('spesifikasi', 'like', '%' . $search . '%');
            })
            ->orderBy('updated_at', 'desc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_po')->where('nomor_po',$po_no)
        ->where(function ($q) use ($search) {
            $q
                ->where('item_cd', 'like', '%' . $search . '%')
                ->orwhere('nomor_po', 'like', '%' . $search . '%')
                ->orwhere('nama', 'like', '%' . $search . '%')
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

    public function inq_po (){
        return view ('sub/inq_po');
    }

    public function inq_openPo (Request $request){
        // dd($request->all());
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $Datas = DB::table('tb_po as a')->leftJoin('tb_po_out as b','a.id_po','=','b.id_po')
        ->select('a.id_po','a.item_cd','a.nomor_po','a.nama','a.spesifikasi','a.qty','a.satuan','a.harga','b.qty_out', DB::raw('a.qty * a.harga as total'))
            ->where(function ($q) use ($search) {
                $q
                    ->where('a.item_cd', 'like', '%' . $search . '%')
                    ->orwhere('a.nomor_po', 'like', '%' . $search . '%')
                    ->orwhere('a.nama', 'like', '%' . $search . '%')
                    ->orwhere('a.spesifikasi', 'like', '%' . $search . '%');
            })
            ->orderBy('a.nomor_po', 'asc')
            ->skip($start)
            ->take($length)
            ->get();

        $count = DB::table('tb_po as a')->leftJoin('tb_po_out as b','a.id_po','=','b.id_po')
        ->select('a.id_po','a.item_cd','a.nomor_po','a.nama','a.spesifikasi','a.qty','a.satuan','a.harga','b.qty_out', DB::raw('a.qty * a.harga as total'))
            ->where(function ($q) use ($search) {
                $q
                    ->where('a.item_cd', 'like', '%' . $search . '%')
                    ->orwhere('a.nomor_po', 'like', '%' . $search . '%')
                    ->orwhere('a.nama', 'like', '%' . $search . '%')
                    ->orwhere('a.spesifikasi', 'like', '%' . $search . '%');
            })
            ->count();

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function upd_kirimPO (Request $request){
        dd($request->all());
    }
}
