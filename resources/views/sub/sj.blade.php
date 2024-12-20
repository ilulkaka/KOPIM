<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Jalan</title>
    <style>
        /* Atur Margin */
        @page {
            margin: 1.44cm 1.778cm 1.905cm 1.778cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }

        /* Header */
        .header {
            text-align: left;
            margin-bottom: 20px;
        }

        .header img {
            height: 70px;
            float: left;
            margin-right: 10px;
        }

        .header h1 {
            font-size: 16px;
            text-align: center;
            margin-top: 20px;
            text-decoration: underline;
        }

        /* Informasi Penerima */
        .receiver-info {
            margin-bottom: 10px;
        }

        .receiver-info table {
            width: 100%;
        }

        .receiver-info td {
            padding: 2px 0;
        }

        /* Tabel Barang */
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .item-table th,
        .item-table td {
            border: 1px solid #000;
            text-align: center;
            padding: 5px;
        }

        .item-table th {
            font-weight: bold;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
        }

        .footer .sign {
            width: 30%;
            display: inline-block;
            text-align: center;
        }

        .footer .city {
            float: right;
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <img src="data:image/png;base64, {{ base64_encode(file_get_contents(public_path('assets/img/BM.png'))) }}"
            alt="Logo Perusahaan">
        <div>
            <strong style="font-size: 14px">BERKAH MANDIRI</strong><br>
            Jl. Kakap No. 4 Blok C04 Dandang B<br>
            Telp: 0857-3330-6147<br>
            Email: kopim.berkahmandiri@gmail.com
        </div>
        <hr>
        <h1>SURAT JALAN</h1>
    </div>

    <!-- Informasi Penerima -->
    <div class="receiver-info" style="margin-top: -2%">
        <table>
            <tr>
                <td><strong>Kepada Yth,</strong></td>
            </tr>
            <tr>
                <td style="line-height: 1.2; padding: 1px 0;"><strong>Nama</strong></td>
                <td style="line-height: 1.2; padding: 1px 0;">:</td>
                <td style="line-height: 1.2; padding: 1px 0;">PT. NPR Manufacturing Indonesia</td>
                <td style="text-align: right; line-height: 1.2; padding: 1px 0;"><strong>Nomor</strong></td>
                <td style="text-align: right; line-height: 1.2; padding: 1px 0;">:</td>
                <td style="text-align: right; line-height: 1.2; padding: 1px 0;">{{ $datas[0]->no_dokumen }}</td>
            </tr>
            <tr>
                <td style="line-height: 1.2; padding: 1px 0;"><strong>Alamat</strong></td>
                <td style="line-height: 1.2; padding: 1px 0;">:</td>
                <td style="line-height: 1.2; padding: 1px 0;">Jl. Rembang Industri II No. 24 Pier Pasuruan</td>
                <td style="text-align: right; line-height: 1.2; padding: 1px 0;"><strong>Tanggal Kirim</strong></td>
                <td style="text-align: right; line-height: 1.2; padding: 1px 0;">:</td>
                <td style="text-align: right; line-height: 1.2; padding: 1px 0;">
                    {{ date('d M Y', strtotime($datas[0]->tgl_kirim)) }}</td>
            </tr>
            <tr>
                <td style="line-height: 1.2; padding: 1px 0;"><strong>No. Telp</strong></td>
                <td style="line-height: 1.2; padding: 1px 0;">:</td>
                <td style="line-height: 1.2; padding: 1px 0;">(0343) 740215</td>
                <td style="text-align: right; line-height: 1.2; padding: 1px 0;"></td>
                <td style="text-align: right; line-height: 1.2; padding: 1px 0;"></td>
            </tr>
        </table>
    </div>

    <!-- Tabel Barang -->
    <table class="item-table">
        <thead>
            <tr>
                <th style="width: 1px">No</th>
                <th>Nama Barang</th>
                <th style="width: 15%">No. PO</th>
                <th style="width: 2px">Jumlah</th>
                <th style="width: 5px">Unit</th>
            </tr>
        </thead>
        @foreach ($datas as $d)
            <tbody style="line-height: 1.2; padding: 2px 0;">
                <tr style="line-height: 1.2;">
                    <td style="padding: 4px;">{{ $loop->iteration }}</td>
                    <td style="text-align: left; padding: 4px;">{{ $d->nama }} {{ $d->spesifikasi }}</td>
                    <td style="padding: 4px;">{{ $d->nomor_po }}</td>
                    <td style="padding: 4px;">{{ $d->qty_out }}</td>
                    <td style="padding: 4px;">{{ $d->satuan }}</td>
                </tr>
            </tbody>
        @endforeach
    </table>

    <!-- Footer -->
    <div class="footer">
        <div class="sign">
            <br>
            <p>
            <p> Penerima,<br><br><br><br><br>
                ..............................
        </div>

        <div class="sign city">
            <p style="padding-right:10px; padding-top:-40px"> Bangil,
                {{ date('d M Y', strtotime($datas[0]->tgl_kirim)) }}<br>
            <p style="padding-right:35px; padding-top:-60px">Pengirim,<br><br><br><br>
            <p style="padding-right: 30px">
                Elis Fitriyani
        </div>
    </div>
</body>

</html>
