namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class FonnteHelper
{
    public static function kirimPesan($nomor, $pesan)
    {
        $token = env('FONNTE_TOKEN');

        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $nomor, // format internasional, contoh: 6281234567890
            'message' => $pesan,
        ]);

        return $response->json();
    }
}