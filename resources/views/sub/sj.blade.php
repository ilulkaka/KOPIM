<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
</head>
<style>
    h5 {
        text-align: left;
        margin-top: 5px;
        font-size: 14px;
        letter-spacing: 10%;
        line-height: 10%;
    }

    .row {
        margin-top: 18px;
        font-size: 16px;
        letter-spacing: 10%;
        text-align: justify;
        line-height: 30px;
        font-family: 'Times New Roman';
    }

    .logo {
        margin: auto;
        margin-left: 50%;
        margin-right: auto;
    }

    .garis1 {
        border-top: 3px solid black;
        height: 1px;
        border-bottom: 1px solid black;
    }

    .pjn {
        text-align: center;
    }

    .ps {
        text-align: center;
    }

    .isi {
        text-align: justify;
        padding-left: 5px;
        padding-top: 0px;
    }

    .rlp {
        text-align: justify;
        padding-top: 6px;
    }

    #ttd {
        text-align: justify;
    }

    #judul {
        padding-top: 50px;
    }

    #halaman {
        width: auto;
        height: auto;
        padding-left: 10px;
        padding-right: 20px;
        padding-bottom: 100px;
    }


    #ttd-2 {
        text-align: right;

    }

    #lampiran {
        text-align: center;
    }


    #hs {
        padding-right: 125px;
    }

    #tgl-srt {
        text-align: left;
        padding-top: 85px;

    }

    .pasal {
        text-align: center;
        line-height: 25px;
    }

    p,
    ol {
        line-height: 25px;
    }

    .page {
        page-break-after: always;
    }

    li {
        padding: -3px;
    }

    @page {
        margin: 50px 70px 10px 80px;
        /* top, right, buttom, left */
    }
</style>
<html>

<body>

    <div class="page">
        <header>
            <table>
                <tr>
                    <td width="70" style="padding-left: -50px; float:left">
<img src="" width="" />
                    </td>
                    <td style="float: left">
                        <span><b style="font-size: 130%"> PT. NPR MANUFACTURING INDONESIA</b><br
                                style="font-size: 14px; padding-top:-10%">
                            Jln. Rembang Industri II No. 24, Kawasan Industri
                            PIER,
                            Pasuruan
                            <br>Telp. 0343-740215, Fax 0343-740217
                            <br><a href="#">Website : http://www.npr.co.jp </a></span>
                    </td>
                    <td width="70" style="float:right">
                        <img src="" width="" />
                    </td>
                </tr>
            </table>
        </header>

        <div class="container">
            <hr class="garis1" />
            <div id="lampiran" class="col-md-12">
                <p class="pjn" style="padding-top: -8px;"><b>PERJANJIAN KERJA UNTUK WAKTU TERTENTU</b><br />
                    Nomor: {{ $sp_nomor }} <br />
                </p>
            </div>
        </div>

        <div id="ket-awal" class="col-md-2">
            <?php
            //$date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            //echo 'Hari ini adalah ' . $date->format('l, d F Y') . ' pukul ' . $date->format('H:i:s') . ' WIB.';
            
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu', 'Minggu'];
            $day_n = date('N');
            ?>


            {{-- <p> Pada hari ini, {{ $days[$day_n - 1] }} tanggal {{ date('d-M-Y') }} , di Pasuruan, yang bertanda tangan
                di bawah ini :
            </p> --}}

            <p> Pada hari ini, {{ $sp_hari }} tanggal {{ $sp_tglsurat }} , di Pasuruan, yang bertanda tangan
                di bawah ini :
            </p>
        </div>

        <?php
        $dd = date_create($datas[0]->tanggal_lahir);
        $mulai = date_create($datas[0]->mulai_kontrak);
        $selesai = date_create($datas[0]->selesai_kontrak);
        $tgl_lamaran = date_create($datas[0]->tanggal_lamaran);
        
        if ($datas[0]->jenis_kelamin == 'P') {
            $jenis = 'PEREMPUAN';
        } else {
            $jenis = 'LAKI-LAKI';
        }
        
        ?>
        <ol type="1" style="padding-left: 14px; text-align:justify; line-height:25px">
            <li style="padding: -3px"><b>Asman Hidayat</b> selaku Personnel & GA Manager, bertindak untuk dan atas
                nama <b> PT. NPR
                    Manufacturing Indonesia </b>beralamat di Jalan Rembang Industri II / 24 Pasuruan, selanjutnya
                dalam
                perjanjian ini disebut PIHAK PERTAMA.</li>
        </ol>
        <ol start="2" style="padding-left: 12px;">
            <li style="padding: 1px">
                <table style="line-height: 15px; ">
            </li>
            <tr>
                <td style="line-height: 15px;">Nama</td>
                <td>: </td>
                <td>{{ $datas[0]->nama }}</td>
            </tr>

            <tr>
                <td style="line-height: 20px;">Tempat,Tgl Lahir</td>
                <td>: </td>
                <td>{{ $datas[0]->tempat_lahir }}, {{ date_format($dd, 'd-M-Y') }}</td>
            </tr>

            <tr>
                <td style="line-height: 20px;">Jenis Kelamin</td>
                <td>: </td>
                <td>{{ $jenis }}</td>
            </tr>

            <tr>
                <td style="line-height: 20px;">Status Kawin</td>
                <td>: </td>
                <td>{{ $datas[0]->status_pernikahan }}</td>
            </tr>
            <tr>
                <td style="line-height:20px;">No. KTP</td>
                <td>: </td>
                <td> {{ $datas[0]->no_ktp }}</td>
            </tr>
            <tr>
                <td style="line-height: 20px;">Alamat</td>
                <td>: </td>
                <td> {{ $datas[0]->alamat }}</td>
            </tr>
            </table>
        </ol>

        <div>
            <p style="padding-left: 12px; text-align:justify">Bertindak untuk dan atas namanya sendiri,
                selanjutnya
                dalam
                perjanjian
                ini
                disebut PIHAK KEDUA.</p>
        </div>

        <div>
            <p style="text-align:justify">Pihak Pertama dan Pihak Kedua secara bersama-sama selanjutnya disebut Para
                Pihak.Para Pihak dengan
                ini
                terlebih dahulu menerangkan hal-hal sebagai berikut:</p>
            <ol type="1" style="padding-left:15px; line-height:25px; text-align:justify">
                <li>Bahwa, PT. NPR Manufacturing Indonesia adalah sebuah perusahaan Badan Hukum Perseroan Terbatas
                    yang
                    ruang lingkup kegiatan usahanya bergerak dibidang Industri Perlengkapan dan Komponen Kendaraan
                    Bermotor Roda Empat atau lebih (Iron Piston Ring);</li>
                <li>Bahwa, untuk menjalankan kegiatan usahanya tersebut, Pihak Pertama membutuhkan Pihak Kedua yang
                    memiliki keahlian dibidang {{ $sp_bidang }} ;</li>
                <li>
                    Bahwa, Pihak pertama telah menerima Pihak Kedua sebagai pekerja berdasarkan surat permohonan lamaran
                    pekerja dari Pihak Kedua tertanggal {{ date_format($tgl_lamaran, 'd-M-Y') }} dan surat pernyataan
                    tertanggal {{ $sp_tglsurat }} ;
                </li>
                <li>Bahwa, Pihak Pertama dalam rangka menjalankan pekerjaan tersebut bermaksud untuk mempekerjakan
                    Pihak
                    Kedua sebagai pekerja tidak tetap berdasarkan <b>Perjanjian Kerja Untuk Waktu Tertentu </b>
                    sebagaimana yang akan diatur dalam perjanjian ini, dan Pihak Kedua telah sepakat untuk bekerja
                    berdasarkan Perjanjian Kerja Untuk Waktu Tertentu tersebut.</li>
            </ol>
            <p style=" padding-top:3px; text-align:justify ">Selanjutnya, untuk maksud seperti yang telah diuraikan
                diatas,
                maka Para
                Pihak
                telah sepakat untuk membuat perjanjian ini dengan ketentuan dan syarat-syarat sebagai berikut:</p>
        </div>
    </div>

    <div class="page">
        <div id="ps-8">
            <p class="ps"><b>Pasal 8</b><br>
                <b>Penyelesaian Perselisihan</b>
            </p>
            <p style="text-align:justify">Apabila timbul perselisihan diantara Para Pihak sebagai akibat dari
                pelaksanaan
                perjanjian ini, maka
                Para
                Pihak sepakat untuk menyelesaikannya secara musyawarah dan kekeluargaan, dan apabila penyelesaian
                secara
                musyawarah dan kekeluargaan tidak mencapai kesepakatan, maka Para Pihak sepakat untuk melibatkan
                pihak
                ketiga melalui mediasi, dan jika penyelesaian melalui mediasi tidak juga dapat menyelesaikan
                perselisihan, maka Para Pihak sepakat untuk menyelesaikannya secara hukum melalui Pengadilan
                Hubungan
                Industrial.</p>&nbsp;
            <p style="font-size: 16px; text-align:justify">Demikian perjanjian ini dibuat dan ditanda tangani oleh
                Para
                Pihak dalam
                keadaan
                sadar tanpa ada unsur paksaan dari pihak manapun serta dibuat dalam rangkap 2 (dua) bermeterai
                cukup,
                yang masing-masing mempunyai kekuatan hukum yang sama.
        </div>

        <br>
        <div>
            Pasuruan, {{ $sp_tglsurat }}
        </div>

        <div id="ttd">
            <div class="col-md-4" style="float: left;">
                <p>Pihak Pertama,<br>
                    PT.NPR Manufacturing Indonesia
                </p>
                <div style="padding-top: 90px;"><u>ASMAN HIDAYAT</u><br />
                    Personnel & GA Manager
                </div>
            </div>
        </div>

        <div id="ttd">
            <div class="col-md-4" style="float: right; padding:13px">
                <p>Pihak Kedua,<br></p>
                <div style="padding-top: 105px;"><u>{{ $datas[0]->nama }}</u><br />
                </div>
            </div>
        </div>
    </div>


    <div class="page">
        <header>
            <table>
                <tr>
                    <td width="70" style="padding-left: -50px; float:left">
                        <img src="" width="" /> />
                    </td>

                    <td style="float: left">
                        <span><b style="font-size: 130%"> PT. NPR MANUFACTURING INDONESIA</b><br
                                style="font-size: 14px; padding-top:-10%">
                            Jln. Rembang Industri II No. 24, Kawasan Industri
                            PIER,
                            Pasuruan
                            <br>Telp. 0343-740215, Fax 0343-740217
                            <br><a href="#">Website : http://www.npr.co.jp </a></span>
                    </td>

                    <td width="70" style="float:right">
                        <img src="" width="" />
                    </td>
                </tr>
            </table>
        </header>



        <div class="container">
            <hr class="garis1" />
            <div id="lampiran" class="col-md-12">
                <p class="pjn" style="padding-top: -8px;"><b>SURAT PERNYATAAN</b><br />
                    Nomor: {{ $sp_nomor }} <br />
                </p>
            </div>
        </div>

        <div class="container">
            <div id="halaman">

                <div>
                    <p>Saya yang bertanda tangan dibawah ini, :</p>
                </div>

                <table style="line-height: 15px; padding-left: 15px;">
                    <tr>
                        <td style="line-height: 15px;">Nama</td>
                        <td>: </td>
                        <td>{{ $datas[0]->nama }}</td>
                    </tr>

                    <tr>
                        <td style="line-height: 20px;">Tempat,Tgl Lahir</td>
                        <td>: </td>
                        <td>{{ $datas[0]->tempat_lahir }}, {{ date_format($dd, 'd-M-Y') }}</td>
                    </tr>

                    <tr>
                        <td style="line-height: 20px;">Jenis Kelamin</td>
                        <td>: </td>
                        <td>{{ $jenis }}</td>
                    </tr>

                    <tr>
                        <td style="line-height: 20px;">Status Kawin</td>
                        <td>: </td>
                        <td>{{ $datas[0]->status_pernikahan }}</td>
                    </tr>
                    <tr>
                        <td style="line-height:20px;">No. KTP</td>
                        <td>: </td>
                        <td> {{ $datas[0]->no_ktp }}</td>
                    </tr>
                    <tr>
                        <td style="line-height: 20px;">Alamat</td>
                        <td>: </td>
                        <td> {{ $datas[0]->alamat }}</td>
                    </tr>
                </table>

                <div>
                    Bersama ini saya menyatakan bahwa :
                    <ol style=" padding-top: 1px; line-height: 25px; text-align:justify">
                        <li style="padding: -1px">Tidak terikat perjanjian kerja dengan perusahaan apapun ataupun
                            instansi lain dimanapun.
                        </li>
                        <li style="padding: -1px">Bersedia bekerja dengan status hubungan kerja Perjanjian Kerja Waktu
                            Tertentu</li>
                        <li style="padding: -1px">Bersedia untuk ditempatkan bekerja pada bagian/jabatan
                            {{ $datas[0]->dept_section }}/{{ $datas[0]->nama_jabatan }} dan bersedia
                            melaksanakan tugas mutasi ke bagian atau jabatan lain sesuai kebutuhan perusahaan
                        </li>
                        <li style="padding: -1px">Bersedia melaksanakan tugas pekerjaan sesuai jangka waktu yang telah
                            diatur dalam
                            Perjanjian Kerja.</li>
                        <li style="padding: -1px">Tidak melakukan tuntutan menjadi PKWTT (pekerja tetap) dengan
                            berakhirnya jangka
                            waktu
                            perjanjian kerja. </li>
                    </ol>
                </div>

                <div class="pntp">
                    <p style=" text-align:justify">Demikian surat pernyataan ini saya buat, dengan
                        kesungguhan
                        serta
                        kemauan sendiri tanpa ada unsur paksaan dari pihak manapun. </p>
                </div>

                <div id="ttd-2">
                    <p style="padding-right:0px; ">Pasuruan, {{ $sp_tglsurat }} <br>
                        Hormat saya,</p><br>
                    <div style=" padding-right: 0px; padding-top:50px;">({{ $datas[0]->nama }})<br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
