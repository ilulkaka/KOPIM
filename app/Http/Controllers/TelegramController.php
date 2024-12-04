<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
}
