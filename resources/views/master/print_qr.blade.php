{{-- <style>
    .container {
        width: 100%;
        padding: 20px;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        /* Menentukan jumlah kolom dan lebar minimal dan maksimal setiap kolom */
        grid-gap: 20px;
        /* Jarak antara item */
    }

    .grid-item {
        width: 97%;
    }

    .item {
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 1px solid #ccc;
        padding: 10px;
    }

    .qr-code {
        width: 150px;
        /* Tetapkan lebar tetap untuk QR code */
        margin-bottom: 10px;
        margin-left: 30px;
        /* Menggeser QR code ke pojok kanan */
        margin-right: auto;
        /* Menggeser QR code ke pojok kanan */
    }

    .qr-info {
        display: flex;
    }

    .info {
        width: 150px;
        margin-left: -60px;
        /* Menggeser QR code ke pojok kanan */
        margin-right: auto;
        /* Menggeser QR code ke pojok kanan */
    }
</style>

<div class="container">
    <div class="grid-container">
        @foreach ($anggota as $index => $pq)
            <div class="grid-item">
                <div class="item">
                    <div class="qr-info">
                        <div class="qr-code">{!! $qrCodes[$index] !!}</div>
                        <div class="info">
                            <p>{{ $pq->nama }}</p>
                            <p style="margin-left:0%; margin-top: -10%">{{ $pq->no_barcode }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div> --}}

<style>
    .container {
        display: flex;
        flex-wrap: wrap;
    }

    .item {
        border: 1px solid #000;
        margin: 5px;
        padding: 5px;
        width: 75px;
        /* Tentukan lebar tetap untuk setiap item */
        text-align: center;
        /* Pusatkan konten dalam setiap item */
    }

    .qr-code {
        margin-bottom: 3px;
        /* Tambahkan jarak antara QR code dan informasi anggota */
    }

    .info p {
        margin: 0;
        /* Hapus margin default untuk paragraf */
    }
</style>

<div class="container">
    @foreach ($anggota as $index => $pq)
        <div class="item">
            <div class="qr-code"> {!! $qrCodes[$index] !!}</div>
            <div class="info">
                <p style="font-size: 12px; font-weight:bold">{{ $pq->no_barcode }}</p>
            </div>
        </div>
    @endforeach
</div>
