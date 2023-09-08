<!DOCTYPE html>
<html>

<head>
    <title>SPPH-{{ $spph->nomor_spph }}</title>
    <style type="text/css">
        @page {
            margin: 0px;
        }

        body {
            margin-top: 3cm;
            margin-left: 2.54cm;
            margin-right: 2.54cm;
            margin-bottom: 0.5cm;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 0.9rem;
        }

        header {
            position: fixed;
            top: 1cm;
            left: 2.54cm;
            right: 2.54cm;
            height: 6cm;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .logo {
            width: 150px;
            height: auto;
            margin-right: 10px;
        }

        .header h2 {
            font-size: 24px;
            margin: 0;
        }

        .line {
            border-top: 3px solid #000;
            margin: 10px 0;
        }

        .address {
            float: left;
            width: 50%;
        }

        .address p {
            margin: 0;
            word-wrap: break-word;
        }

        .date {
            text-align: right;
        }

        .info-surat {
            clear: both;
            text-align: left;
        }

        .info-surat p {
            margin: 0;
        }
        .judul-konten {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        .content {
            margin-top: 10px;
            line-height: 1.5;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .table-2{
            width: 100%;
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <header>
        <div class="header">
            <table style="width: 100%">
                <tr>
                    <td style="width: 10%">
                    <img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png"
                        alt="Logo IMSS" class="logo">
                    </td>
                    <td style="width: 75%">
                        <h2>PT INKA MULTI SOLUSI SERVICE</h2>
                        <p style="margin: 0;"> 
                            <b>SERVICE - MAINTENANCE - LOGISTICS - GENERAL CONTRACTOR</b>
                        </p>
                        <p style="margin: 0;">Jl. Salak No. 59 Madiun - 63131</p>
                    </td>
                </tr>
            </table>
        </div>
        <div class="line"></div>
    </header>

    <div class="container">

        <div class="date">
            <p>Tanggal: 01 September 2023</p>
        </div>
        <div class="info-surat">
            <p><span class="label">Nomor Surat &nbsp;&nbsp;: {{ $spph->nomor_spph }}</span></p>
            <p><span class="label">Lampiran&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span></p>
            <p><span class="label">Perihal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </span>{{ $spph->perihal }}</p>
        </div>
        <div class="address">
            <br>
            <p>Kepada Yth,</p>
            <p>
                <b>{!!  nl2br($spph->penerima) !!}</b>
            </p>
            <p>{{$spph->alamat}}</p>
        </div>
        <div style="clear: both;"></div>
        <div class="judul-konten"><u>SURAT PERMINTAAN PENAWARAN HARGA</u><br>(SPPH)</div>
        <div class="content">
            <p>Dengan Hormat,</p>
            <p>
                Memberitahukan bahwa perusahaan kami dalam waktu dekat ini bermaksud untuk melakukan pekerjaan sebagai
                tersebut :
            </p>

            <table class="table" align="center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>Spesifikasi</th>
                        <th>Qty</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Wrought Steel Wheel</td>
                        <td>Wrought Steel Wheel <br> Drawing No. 01.1-E11001</td>
                        <td>48</td>
                        <td>Pcs</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Wrought Steel Wheel</td>
                        <td>Wrought Steel Wheel <br> Drawing No. 01.1-E11001</td>
                        <td>48</td>
                        <td>Pcs</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Wrought Steel Wheel</td>
                        <td>Wrought Steel Wheel <br> Drawing No. 01.1-E11001</td>
                        <td>48</td>
                        <td>Pcs</td>
                    </tr>
                </tbody>
            </table>

            <p>
                Berkaitan dengan hal tersebut diatas mohon bantuannya untuk Penawaran Harga pekerjaan dimaksud.
                Jawaban atas penawaran referensi harga kami tunggu paling lambat 12 September 2023 dengan catatan
                sebagai berikut :
            </p>

            <table class="tabel-2" style="width:100%">
                <tr>
                    <td style="width: 1rem;vertical-align:top">1.</td>
                    <td style="width: 10rem;vertical-align:top">Delivery</td>
                    <td style="vertical-align:top">:</td>
                    <td style="vertical-align:top">2 (dua) minggu setelah PO</td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Franko</td>
                    <td>:</td>
                    <td>PT IMSS </td>
                </tr>
                <tr>
                    <td style="vertical-align:top">3.</td>
                    <td style="vertical-align:top">Termin Pembayaran</td>
                    <td style="vertical-align:top">:</td>
                    <td>Pembayaran 30 hari setelah barang diterima baik dan benar, serta dokumen penagihan diterima
                        dengan benar & lengkap oleh PT IMSS</td>
                </tr>
            </table>

            <p>Demikian kami sampaikan, atas kerjasamanya diucapkan terima kasih.</p>
        </div>

        <div style="margin-left: 65%; width: 50%; margin-top: 5%">
            <table class="w-100">
                <tr>
                    <td class="text-center"><b>PT INKA MULTI SOLUSI SERVIS</b></td>
                </tr>
                <tr>
                    <td class="text-center" style="text-align: center"><b>KEPALA DEPARTEMEN LOGISTIK</b></td>
                </tr>
                <tr>
                    <td style="height: 70px"></td>
                </tr>
                <tr>
                    <td class="text-center" style="text-align: center"><b style="text-decoration: underline; ">(RUDI HARIYANTO)</b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
