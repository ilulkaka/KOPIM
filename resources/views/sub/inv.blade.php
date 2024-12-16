<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
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
        <h1>INVOICE</h1>
    </div>

    <!-- Informasi Penerima -->
    <div class="receiver-info" style="margin-top: -2%">
        <table>
            <tr>
                <td><strong>BILL TO,</strong></td>
            </tr>
            <tr>
                <td>PT. NPR Manufacturing Indonesia</td>
                <td style="text-align: right"><strong>Nomor</strong></td>
                <td style="text-align: right">:</td>
                <td style="text-align: right">{{ $datas[0]->no_dokumen }}</td>
            </tr>
            <tr>
                <td>Jl. Rembang Industri II No. 24 Pier Pasuruan</td>
                <td style="text-align: right"><strong>Tanggal Kirim</strong></td>
                <td style="text-align: right">:</td>
                <td style="text-align: right">{{ date('d M Y', strtotime($datas[0]->tgl_kirim)) }}</td>
            </tr>
            <tr>
                <td>(0343) 740215</td>
            </tr>
        </table>
    </div>

    <!-- Tabel Barang -->
    <?php $subtotal = 0; ?>
    <table class="item-table">
        <thead>
            <tr>
                <th style="width: 15%">No. PO</th>
                <th>Description</th>
                <th style="width: 2px">Qty</th>
                <th style="width: 5px">Unit</th>
                <th style="width: 12%">Price</th>
                <th style="width: 15%">Amount</th>
            </tr>
        </thead>
        @foreach ($datas as $d)
            <?php $subtotal += $d->total; ?>
            <tbody>
                <tr>
                    <td>{{ $d->nomor_po }}</td>
                    <td style="text-align: left">{{ $d->nama }} {{ $d->spesifikasi }}</td>
                    <td>{{ $d->qty_out }}</td>
                    <td>{{ $d->satuan }}</td>
                    <td style="text-align: right">{{ number_format($d->harga, 0, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($d->total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        @endforeach
    </table>

    <!-- Informasi Penerima -->
    <div class="receiver-info" style="margin-top: -2%">
        <table>
            <tr>
                <td><strong>Bank Transfer,</strong></td>
            </tr>
            <tr>
                <td style="width: 15%"><strong>Bank Account</strong></td>
                <td style="width:5px">:</td>
                <td>BRI</td>
                <td style="width: 10%; text-align:right"><strong>SUBTOTAL</strong></td>
                <td style="width:5px; text-align:right">:</td>
                <td style="width:15%; text-align:right">{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Account No</strong></td>
                <td>:</td>
                <td> 006501074573500</td>
                <td style="width: 20%; text-align:right"><strong>TAX</strong></td>
                <td>:</td>
                <td style="text-align: right">0</td>
            </tr>
            <tr>
                <td><strong>Account Name</strong></td>
                <td>:</td>
                <td>Nur Khalimah</td>
                <td style="width: 20%; text-align:right"><strong>SALES TAX</strong></td>
                <td>:</td>
                <td style="text-align: right">0</td>
            </tr>
            <tr class="line-below">
                <td><strong></strong></td>
                <td></td>
                <td></td>
                <td style="width: 20%; text-align:right; "><strong>OTHER</strong></td>
                <td>:</td>
                <td style="text-align: right; border-bottom: 1px solid #000;">0</td>
            </tr>
            <tr>
                <td><strong></strong></td>
                <td></td>
                <td></td>
                <td style="width: 20%; text-align:right"><strong>TOTAL</strong></td>
                <td>:</td>
                <td style="text-align: right">{{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>


    <div class="footer">
        <p>Bangil, {{ date('d-M-Y') }}<br>Hormat Kami,<br><br><br><br>Siswatun Navilla</p>
    </div>
</body>

</html>
