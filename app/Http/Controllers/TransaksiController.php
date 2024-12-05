<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
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
use PHPMailer\PHPMailer\PHPMailer;

class TransaksiController extends Controller
{

    private $botToken;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN'); // Ganti dengan token bot Anda
    }

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
                'message' => 'Barcode salah .',
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
        // Ambil ID anggota
        $id_anggota = substr($request->trx_nobarcode, 16);
        $datas = DB::table('tb_anggota')
            ->select('id_anggota', 'no_barcode', 'nik', 'nama', 'no_telp', 'chat_id')
            ->where('id_anggota', $id_anggota)
            ->where('status', '=', 'Aktif')
            ->get();

        $chatId = $datas[0]->chat_id;

        // Validasi jika data kosong
        if ($datas->isEmpty()) {
            return response()->json([
                'message' => 'Data anggota tidak ditemukan atau status tidak aktif.',
                'success' => false,
            ], 404);
        }

        $kategori = $request->input('trx_kategori');
        $no_barcode = ($kategori == 'Anggota') ? $datas[0]->no_barcode : '999999';
        $date_trx = ($request->role1 == 'Administrator') ? $request->tgl_trx : date('Y-m-d');
        $idTrx = Str::uuid();

        // Insert data transaksi
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
            // Validasi nomor telepon
            if (empty($chatId)) {
                return response()->json([
                    'message' => "Transaksi berhasil ! \nChat ID tidak tersedia untuk anggota ini.",
                    'success' => true,
                ]);
            } else {
                $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
                $formattedNominal = 'Rp ' . number_format($request->trx_nominal, 0, ',', '.');  // Format nominal menjadi Rupiah
                Http::post($url, [
                    'chat_id' => $chatId,
                    'text' => "Halo, <b>".$datas[0]->nama."</b> ! \nTransaksi anda sebesar <b>".$formattedNominal."</b> \npada tanggal ".date('d-m-Y H:i:s'). " \n\n Terima Kasih.",
                    'parse_mode' => 'HTML' // Gunakan 'HTML' atau 'Markdown'
                ]);            
    
                return response()->json([
                    'message' => 'Transaksi berhasil!',
                    'success' => true,
                ]);
            }

        } else {
            return response()->json([
                'message' => 'Gagal menyimpan transaksi!',
                'success' => false,
            ]);
        }
    }


    /*
    public function trx_simpan(Request $request)
    {
        // dd($request->all());
        $id_anggota = substr($request->trx_nobarcode, 16);
        $datas = DB::table('tb_anggota')
            ->select('id_anggota', 'no_barcode', 'nik', 'nama', 'no_telp')
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

              // Konfigurasi pengiriman WA
        $response = Http::withHeaders([
            'Authorization' => 'LMjyNNhxuSK8pDpa4Z9n', // Ganti dengan token Anda
        ])->post('https://api.fonnte.com/send', [
            'target' => $datas[0]->no_telp, // Nomor WA tujuan dari input request
            'message' => 'Halo, ' . $datas[0]->nama . '! Transaksi berhasil dengan nominal: ' . $request->trx_nominal,
        ]);

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
*/
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
        // dd($request->all());
        $tgl_awal = Carbon::createFromFormat(
            'Y-m-d',
            $request->tgl_awal
        )->format('d-m-Y');
        $tgl_akhir = Carbon::createFromFormat(
            'Y-m-d',
            $request->tgl_akhir
        )->format('d-m-Y');

        $Datas = DB::select(
            "select no_barcode, nik, nama, sum(nominal)as nominal, kategori from tb_trx_belanja where tgl_trx >= '$request->tgl_awal' and tgl_trx <='$request->tgl_akhir' group by no_barcode, nik, nama, kategori order by nik "
        );

        if (count($Datas) > 0) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->mergeCells('A1:F1');
            $sheet->setCellValue(
                'A1',
                'Transaksi dari Tanggal ' . $tgl_awal . ' Sampai ' . $tgl_akhir
            );
            $sheet->setCellValue('A2', 'No');
            $sheet->setCellValue('B2', 'No Barcode');
            $sheet->setCellValue('C2', 'NIK');
            $sheet->setCellValue('D2', 'NAMA');
            $sheet->setCellValue('E2', 'Nominal');
            $sheet->setCellValue('F2', 'Kategori');

            $line = 3;
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

    public function send_mail(Request $request)
    {
        // dd($request->all());

        require base_path('vendor/autoload.php');
        $mail = new PHPMailer(true); // Passing `true` enables exceptions

        $m_tgl_awal = Carbon::createFromFormat(
            'Y-m-d',
            $request->m_tgl_awal
        )->format('d-m-Y');
        $m_tgl_akhir = Carbon::createFromFormat(
            'Y-m-d',
            $request->m_tgl_akhir
        )->format('d-m-Y');

        $user_mail = 'cs.kopim@kopbm.com';
        $user_pass = 'Cskopim12%';

        $mailSendTo = $request->sm_to;
        $mailSendToCC = $request->sm_cc;
        // data pengaju cuti
        // $datasCuti = CutiModel::where('id_cuti', $idCuti)->get();
        // $filename =
        //     $datasCuti[0]->nomer_report . '_' . $datasCuti[0]->nama . '.pdf';

        try {
            // Konfigurasi SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = $user_mail;
            $mail->Password = $user_pass;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set pengirim dan penerima
            $mail->setFrom($user_mail, 'CS KOPIM');
            $mail->addAddress($mailSendTo, $mailSendTo);

            $mail->addCC($mailSendToCC);
            //$mail->addBCC($request->emailBcc);
            $mail->AddAttachment(public_path('storage/excel/Transaksi.xlsx'));

            // Konten email
            $mail->isHTML(true);
            $mail->Subject = 'Rekap Transaksi Kopim';
            $mail->Body =
                'Untuk bagian pemotongan .
            <br>
            <br>
            Terlampir adalah rekap transaksi untuk periode <br><b>' .
                $m_tgl_awal .
                '</b> Sampai <b>' .
                $m_tgl_akhir .
                '</b> 
            <br>
            <br>
            Terima Kasih <br>
            KOPIM';

            // Kirim email
            $mail->send();

            return [
                'message' => 'Email berhasil dikirim.',
                'success' => true,
            ];
        } catch (Exception $e) {
            return "Email gagal dikirim: {$mail->ErrorInfo}";
            return [
                'message' => "Email gagal dikirim: {$mail->ErrorInfo}",
                'success' => false,
            ];
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


    public function getUpdates()
    {
        // dd(url('/'));
        // URL API Telegram
        $url = "https://api.telegram.org/bot{$this->botToken}/getUpdates";

        // Kirim permintaan ke API Telegram
        $response = Http::get($url);

        // Decode hasil JSON
        $updates = $response->json();

        // Periksa apakah ada pembaruan
        if ($updates['ok'] && !empty($updates['result'])) {
            foreach ($updates['result'] as $update) {
                // Ambil chat_id dan update_id dari update
                $chatId = $update['message']['chat']['id'] ?? null;
                $updateId = $update['update_id'] ?? null;
                $message = $update['message'] ?? null;
                $text = $message['text'] ?? null;

                if ($chatId && $updateId) {
                    // Ambil update_id terakhir dari cache untuk chat_id tertentu
                    $lastUpdateId = \Cache::get('telegram_last_update_id_' . $chatId, 0);

                    // Proses hanya pembaruan baru berdasarkan update_id
                    if ($updateId > $lastUpdateId) {
                        if ($message) {
                            if ($text && preg_match('/^\d{10,15}$/', $text)) { // Validasi nomor telepon
                                $anggota = \DB::table('tb_anggota')->where('no_telp', $text)->first();

                                if ($anggota) {
                                    if ($anggota->chat_id) {
                                        // Jika chat_id sudah ada
                                        $this->sendMessage($chatId, "Nomor telepon sudah terdaftar.");
                                    } else {
                                        // Perbarui chat_id jika belum ada
                                        \DB::table('tb_anggota')
                                            ->where('no_telp', $text)
                                            ->update(['chat_id' => $chatId]);

                                        $this->sendMessage($chatId, "Nomor berhasil terdaftar.");
                                    }
                                } else {
                                    $this->sendMessage($chatId, "Nomor telepon tidak ditemukan di database.");
                                }
                            } else {
                                $this->sendMessage($chatId, "Mohon kirimkan nomor telepon yang valid.");
                            }
                        }

                        // Perbarui lastUpdateId dengan update_id terbaru
                        \Cache::put('telegram_last_update_id_' . $chatId, $updateId);
                    }
                }
            }
        }
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

    public function handleWebhook(Request $request)
    {
        // Ambil payload dari webhook
        $update = $request->all();

        // Periksa apakah ada data 'message'
        if (!empty($update['message'])) {
            $message = $update['message'];
            $chatId = $message['chat']['id'] ?? null;
            $text = $message['text'] ?? null;

            if ($chatId && $text) {
                // Logika penanganan berdasarkan teks
                if (preg_match('/^\d{10,15}$/', $text)) { // Jika teks berupa nomor telepon
                    $anggota = DB::table('tb_anggota')->where('no_telp', $text)->first();

                    if ($anggota) {
                        if ($anggota->chat_id) {
                            // Jika chat_id sudah ada
                            $this->sendMessage($chatId, "Nomor telepon sudah terdaftar.");
                        } else {
                            // Perbarui chat_id jika belum ada
                            DB::table('tb_anggota')->where('no_telp', $text)->update(['chat_id' => $chatId]);
                            $this->sendMessage($chatId, "Nomor berhasil terdaftar.");
                        }
                    } else {
                        $this->sendMessage($chatId, "Nomor telepon tidak ditemukan di database.");
                    }
                } else {
                    $this->sendMessage($chatId, "Mohon kirimkan nomor telepon yang valid.");
                }
            }
        }
    }

}
