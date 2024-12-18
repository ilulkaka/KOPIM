<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\MasterPOModel;
use App\Models\POModel;
use App\Models\POOutModel;
use PDF;

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
            'item_cd' => strtoupper($request->itemCd), // Ubah ke huruf besar
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
        $sekarang = date('Y-m-d');
        $lastNumber = DB::select("select max(no_dokumen)as lastNumber from tb_po_out where tgl_kirim = '$sekarang' ");

        if (empty($lastNumber) || $lastNumber[0]->lastNumber === null) {
            $lastN = 0;
        } else {
            $lastN = $lastNumber[0]->lastNumber;
        }

        return view ('sub/inq_po',['lastNumber' => $lastN]);
    }

    public function inq_openPo (Request $request){
        // dd($request->all());
        $draw = $request->input('draw');
        $search = $request->input('search')['value'];
        $start = (int) $request->input('start');
        $length = (int) $request->input('length');

        $statusPO = $request->statusPO;
        $f_tgl = $request->f_tgl;

        if($statusPO == 'Open' && $f_tgl == null){
            $tgl = '';
            $asc = 'order by nouki asc';
        } else if($statusPO == 'Open' && $f_tgl != null) {
            $tgl = "and nouki <='$f_tgl'";
            $asc = 'order by nouki asc';
        } else if($statusPO == 'Closed' && $f_tgl == null){
            $tgl = '';
            $asc = 'order by nouki desc';
        } else {
            $tgl = "and nouki ='$f_tgl'";
            $asc = 'order by nouki desc';
        }
        // dd($tgl);
        $Datas = DB::select("SELECT a.*, b.qty_out, a.qty - b.qty_out as temp_plan, a.qty * a.harga as total FROM
        (select * FROM tb_po where status_po = '$statusPO' $tgl )a 
        left join
        (select id_po, SUM(qty_out)as qty_out FROM tb_po_out group by id_po)b on a.id_po = b.id_po
        where (a.item_cd like '%$search%' or a.nomor_po like '%$search%') $asc LIMIT $length OFFSET $start");


        $co = DB::select("SELECT a.*, b.qty_out, a.qty - b.qty_out as temp_plan, a.qty * a.harga as total FROM
        (select * FROM tb_po where status_po = '$statusPO' $tgl)a 
        left join
        (select id_po, SUM(qty_out)as qty_out FROM tb_po_out group by id_po)b on a.id_po = b.id_po");
        $count = count($co);

        return [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $Datas,
        ];
    }

    public function get_noDok (Request $request){
        // Ambil nomor terakhir dari kolom po_nomor
        $lastDokNomor = POOutModel::orderBy('no_dokumen', 'desc')->value('no_dokumen');

        // Ambil bulan dan tahun saat ini
        $bulan = date('m');
        $tahun = date('Y');

        // Parse nomor terakhir (jika ada) dan increment
        if ($lastDokNomor) {
            // Ambil tahun dari nomor terakhir (asumsi format: 0002122024)
            $lastYear = substr($lastDokNomor, -4);

            if ($lastYear == $tahun) {
                // Tahun sama, ambil angka terakhir dan increment
                $lastNumber = (int)substr($lastDokNomor, 0, 3);
                $nextNumber = $lastNumber + 1;
            } else {
                // Tahun berbeda, reset nomor ke 1
                $nextNumber = 1;
            }
        } else {
            // Jika belum ada nomor terakhir, mulai dari 1
            $nextNumber = 1;
        }

        // Format nomor baru menjadi 3 angka
        $formattedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // Gabungkan menjadi nomor PO baru
        $newDokNomor = $formattedNumber . $bulan . $tahun;

        // Return data ke client
        return response()->json([
            'success' => true,
            'last_dok_nomor' => $lastDokNomor,
            'new_dok_nomor' => $newDokNomor,
        ]);
    }

    public function upd_kirimPO (Request $request){
        // dd($request->all()); 

        // Mengambil array selectedIDs yang dikirim melalui AJAX
        $selectedIDs = $request->input('selectedIDs');
        $noDokumen = $request->noDokumen;
        // Cek jika selectedIDs ada dan berisi data
        if (!$selectedIDs || count($selectedIDs) === 0) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data yang dipilih']);
        }

        // Proses setiap item dalam selectedIDs
        foreach ($selectedIDs as $item) {
            $id_po = $item['id'];
            $plan_qty = $item['plan_qty'];
            $sisa = $item['sisa'];

            // Ambil data dari tb_po berdasarkan id_po
            $poData = \DB::table('tb_po')->where('id_po', $id_po)->first();

            // Cek jika data ditemukan
            if ($poData) {
                // Insert data ke tb_po_out
                $ins = POOutModel::create([
                    'id_po_out' => str::uuid(),
                    'id_po' => $poData->id_po,
                    'tgl_po' => $poData->tgl_po,
                    'nomor_po' => $poData->nomor_po,
                    'item_cd' => $poData->item_cd,
                    'nama' => $poData->nama,
                    'spesifikasi' => $poData->spesifikasi,
                    'qty_in' => $poData->qty,
                    'qty_out' => $plan_qty, // Gunakan plan_qty yang diterima
                    'satuan' => $poData->satuan,
                    'harga' => $poData->harga,
                    'total' => $plan_qty * $poData->harga,
                    'nouki' => $poData->nouki,
                    'no_dokumen' => $noDokumen,
                    'tgl_kirim' => date ('Y-m-d'),
                ]);

                // Jika sisa = 0, update status pada tb_po
                if ($sisa == 0) {
                    POModel::where('id_po', $id_po)->update([
                        'status_po' => 'Closed' // Update status menjadi 'closed' atau sesuai kebutuhan
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Data berhasil dikirim']);
    }

    public function cetak_sj ($noDok){
        $datas = POOutModel::where('no_dokumen',$noDok)->get();

        $pdf = PDF::loadview('/sub/sj',['datas'=>$datas])->setPaper('A4', 'potrait');
        return $pdf->stream('Surat Jalan.pdf');
    }

    public function cetak_inv ($noDok){
        $datas = POOutModel::where('no_dokumen',$noDok)->get();

        $pdf = PDF::loadview('/sub/inv',['datas'=>$datas])->setPaper('A4', 'potrait');
        return $pdf->stream('Surat Jalan.pdf');
    }
}
