<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\AnggotaModel;

class TelegramController extends Controller
{
    private $botToken;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN'); // Ganti dengan token bot Anda
    }

    public function lap_transaksi (){
        return view ('laporan/lap_transaksi');
    }

    public function rekapTransaksi (Request $request){
        // dd($request->all());
        $today = date('Y-m-d');
        $dateSend = date('Y-m') . '-20';

        $carbonDateSend = Carbon::create(date('Y'), date('m'), 20); // Tanggal sekarang (contoh)

        // Kurangi 1 bulan dari tanggal saat ini dan tetapkan hari ke-16
        $per_awal = $carbonDateSend->copy()->subMonth()->format('Y-m') . '-16';
        // Tetapkan hari ke-15 dari bulan saat ini
        $per_akhir = $carbonDateSend->format('Y-m') . '-15';

        $dateFormatAwal = date('d M Y', strtotime($per_awal));
        $dateFormatAkhir = date('d M Y', strtotime($per_akhir));

        // Filter
        $tgl1 = date('Y-m').'-01';
        $tgl2 = date('Y-m-t', strtotime($tgl1)); // Tanggal akhir bulan
        // 1877499384
        $datas = DB::select("
        SELECT a.nama, a.no_barcode, a.chat_id, b.total, c.jml_angsuran as pinjaman, d.jml_simpanan as simpanan FROM 
        (select nama, no_barcode, chat_id from tb_anggota WHERE chat_id is not null)a 
        LEFT JOIN 
        (select no_barcode, sum(nominal)as total from tb_trx_belanja where tgl_trx between '$per_awal' and '$per_akhir'
        group by no_barcode)b on a.no_barcode = b.no_barcode
        LEFT JOIN 
        (select no_anggota, jml_angsuran FROM tb_pembayaran WHERE tgl_angsuran BETWEEN '$tgl1' and '$tgl2')c 
        on b.no_barcode = c.no_anggota
        LEFT JOIN 
        (select no_anggota, jml_simpanan from tb_simpanan WHERE jenis_simpanan = 'Wajib' and tgl_simpan = '$tgl1')d 
        on a.no_barcode = d.no_anggota");
// dd($datas);
        // Loop through each record and send the message to the chat_id
        foreach ($datas as $data) {
            $nama = $data->nama;
            $noBarcode = $data->no_barcode;
            $chatId = $data->chat_id;
            $transaksi = $data->total ?? 0; // Jika tidak ada total, anggap 0
            $pinjaman = $data->pinjaman ?? 0;
            $simpanan = $data->simpanan ?? 0;
            $shu = 0;

            $totalkredit = $transaksi + $pinjaman ;
            $totaldebit = $shu + $simpanan;

            if ($chatId) {
                // Format the message
                $message = "
                <b> - Pesan ini untuk keperluan developer, 
                Mohon abaikan.</b>


                <b> 📋 Rekap Anggota KOPIM 📋 </b>
<b>$dateFormatAwal</b> - <b>$dateFormatAkhir</b>  
------------------------------------
Nama            : <b>$nama</b>
No Anggota  : <b>$noBarcode</b>

<b>⭐️ Kredit </b>
    - Transaksi   : <b>Rp " . number_format($transaksi, 2, ',', '.') . "</b>  
    - Pinjaman   : <b>Rp " . number_format($pinjaman, 2, ',', '.') . "</b>
    <b>* Total  : Rp " . number_format($totalkredit, 2, ',', '.') . "</b>

<b>💳 Debit </b>
    - Simpanan  : <b>Rp " . number_format($simpanan, 2, ',', '.') . "</b> 
    - SHU            : <b>Rp " . number_format($shu, 2, ',', '.') . "</b>  
    <b>* Total  : Rp " . number_format($totaldebit, 2, ',', '.') . "</b>
    
------------------------------------

<b> Terima Kasih </b>

";


                // Kirim pesan ke chat_id
                $this->sendMessage($chatId, $message);
            } else {
                // Log jika tidak ada chat_id untuk no_barcode
                \Log::warning("Chat ID tidak ditemukan untuk no_barcode: $noBarcode");
            }
        }

        // $this->sendMessage($chatId, $datas);

    }

    private function sendMessage($chatId, $message)
    {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML' // Gunakan 'HTML' atau 'Markdown'
        ]);
    }

    public function frm_sendTelegram (){
        $nama = DB::table('tb_anggota')->select('nama','no_barcode','chat_id')->where('status','!=','Off')->where('chat_id','!=',null)->get();
        return view ('laporan/send_telegram',['nama'=>$nama]);
    }

    public function manual_sendTelegram (Request $request){
            // dd($request->all());
    
            $per_awal = $request->st_trxAwal;
            $per_akhir = $request->st_trxAkhir;
    
            $dateFormatAwal = date('d M Y', strtotime($per_awal));
            $dateFormatAkhir = date('d M Y', strtotime($per_akhir));
    
            // Filter
            $tgl1 = $request->st_perAngsuran.'-01';
            $tgl2 = date('Y-m-t', strtotime($tgl1)); // Tanggal akhir bulan

            $chatId = $request->st_anggota;

            if($chatId == 'All'){
                $chat_id = 'chat_id is not null';
            } else {
                $chat_id = "chat_id = '$chatId'";
            }

            // 1877499384
            // $datas = DB::select("
            // SELECT a.nama, a.no_barcode, a.chat_id, b.total, c.jml_angsuran as pinjaman, c.angsuran_ke, d.jml_simpanan as simpanan FROM 
            // (select nama, no_barcode, chat_id from tb_anggota WHERE $chat_id)a 
            // LEFT JOIN 
            // (select no_barcode, sum(nominal)as total from tb_trx_belanja where tgl_trx between '$per_awal' and '$per_akhir'
            // group by no_barcode)b on a.no_barcode = b.no_barcode
            // LEFT JOIN 
            // (select no_anggota, jml_angsuran, angsuran_ke FROM tb_pembayaran WHERE tgl_angsuran BETWEEN '$tgl1' and '$tgl2')c 
            // on b.no_barcode = c.no_anggota
            // LEFT JOIN 
            // (select no_anggota, jml_simpanan from tb_simpanan WHERE jenis_simpanan = 'Wajib' and tgl_simpan = '$tgl1')d 
            // on a.no_barcode = d.no_anggota");

            $datas = DB::select("
                SELECT 
                    a.nama, 
                    a.no_barcode, 
                    a.chat_id, 
                    b.total, 
                    COALESCE(c.jml_angsuran1, 0) as pinjaman1, 
                    COALESCE(c.angsuran1, 0) as angsuran1,
                    COALESCE(c.jml_angsuran2, 0) as pinjaman2, 
                    COALESCE(c.angsuran2, 0) as angsuran2,
                    COALESCE(d.jml_simpanan_wajib, 0) as simpanan_wajib,
                    COALESCE(d.jml_simpanan_pokok, 0) as simpanan_pokok
                FROM 
                    (SELECT nama, no_barcode, chat_id FROM tb_anggota WHERE $chat_id) a 
                LEFT JOIN 
                    (SELECT no_barcode, SUM(nominal) as total 
                    FROM tb_trx_belanja 
                    WHERE tgl_trx BETWEEN '$per_awal' AND '$per_akhir'
                    GROUP BY no_barcode) b 
                ON a.no_barcode = b.no_barcode
                LEFT JOIN
                    (select no_anggota, 
                    MAX(CASE WHEN rn = 1 THEN jml_angsuran ELSE NULL END) as jml_angsuran1,
                    MAX(CASE WHEN rn = 1 THEN angsuran_ke ELSE NULL END) as angsuran1,
                    MAX(CASE WHEN rn = 2 THEN jml_angsuran ELSE NULL END) as jml_angsuran2,
                    MAX(CASE WHEN rn = 2 THEN angsuran_ke ELSE NULL END) as angsuran2
                FROM (
                        SELECT 
                            no_anggota, 
                            jml_angsuran, 
                            angsuran_ke,
                            ROW_NUMBER() OVER (PARTITION BY no_anggota ORDER BY tgl_angsuran) as rn
                        FROM tb_pembayaran
                        WHERE tgl_angsuran BETWEEN '$tgl1' AND '$tgl2'
                    ) subquery
                    GROUP BY no_anggota) c 
                ON b.no_barcode = c.no_anggota
                LEFT JOIN 
                    (SELECT 
                        no_anggota, 
                        SUM(CASE WHEN jenis_simpanan = 'Wajib' THEN jml_simpanan ELSE 0 END) as jml_simpanan_wajib,
                        SUM(CASE WHEN jenis_simpanan = 'Pokok' THEN jml_simpanan ELSE 0 END) as jml_simpanan_pokok
                    FROM tb_simpanan 
                    GROUP BY no_anggota) d 
                ON a.no_barcode = d.no_anggota
            ");

// dd($datas);
            // Loop through each record and send the message to the chat_id
            foreach ($datas as $data) {
                $nama = $data->nama;
                $noBarcode = $data->no_barcode;
                $chatId = $data->chat_id;
                $transaksi = $data->total ?? 0; // Jika tidak ada total, anggap 0
                $pinjaman1 = $data->pinjaman1 ?? 0;
                $angsuran1_ke = $data->angsuran1 ?? 0;
                $pinjaman2 = $data->pinjaman2 ?? 0;
                $angsuran2_ke = $data->angsuran2 ?? 0;
                $simpanan_wajib = $data->simpanan_wajib ?? 0;
                $simpanan_pokok = $data->simpanan_pokok ?? 0;
                $shu = 0;
    
                $totalkredit = $transaksi + $pinjaman1 + $pinjaman2 ;
                $totaldebit = $shu + $simpanan_wajib + $simpanan_pokok;
    
                if ($chatId) {
                    // Format the message
                    $message = "
<b> 📌 Rekap Anggota KOPIM  </b>
<b>$dateFormatAwal</b> - <b>$dateFormatAkhir</b>  
------------------------------------
Nama             : <b>$nama</b>
No Anggota  : <b>$noBarcode</b>
    
<b>💸 Kredit </b>
- Transaksi               : <b>Rp " . number_format($transaksi, 0, ',', '.') . "</b>  
- Angsuran_A ke-<b>".$angsuran1_ke."</b>   : <b>Rp " . number_format($pinjaman1, 0, ',', '.') . "</b>
- Angsuran_B ke-<b>".$angsuran2_ke."</b>   : <b>Rp " . number_format($pinjaman2, 0, ',', '.') . "</b>
<b>* Total                  : Rp " . number_format($totalkredit, 0, ',', '.') . "</b>
    
<b>💳 Debit </b>
    - Simpanan Wajib  : <b>Rp " . number_format($simpanan_wajib, 0, ',', '.') . "</b>
    - Simpanan Pokok : <b>Rp " . number_format($simpanan_pokok, 0, ',', '.') . "</b> 
    - SHU                      : <b>Rp " . number_format($shu, 0, ',', '.') . "</b>  
    <b>💰 Total                : Rp " . number_format($totaldebit, 0, ',', '.') . "</b>
        
------------------------------------
    
    <b> Terima Kasih </b>
    🙏
    
    ";
    
    
                    // Kirim pesan ke chat_id
                    $this->sendMessage($chatId, $message);

                    return
                    [
                        'message' => 'Kirim Pesan ke Telegram Berhasil .',
                        'success' => true,
                    ];
                } else {
                    // Log jika tidak ada chat_id untuk no_barcode
                    \Log::warning("Chat ID tidak ditemukan untuk no_barcode: $noBarcode");
                }
            }
    
            // $this->sendMessage($chatId, $datas);
    
        }
}
