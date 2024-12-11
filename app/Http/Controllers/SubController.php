<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\MasterPOModel;

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
        dd($request->all());
        $getDatas = MasterPOModel::where('item_cd',$request->tdpo_item)->get();
    }
}
