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
            margin-bottom: 2cm;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 0.9rem;
        }

        header {
            position: fixed;
            top: 0.7cm;
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

        .table-2 {
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
            <p>{{ $spph->tanggal_spph }}</p>
        </div>
        <div class="info-surat">
            <p><span class="label">Nomor Surat &nbsp;&nbsp;: {{ $spph->nomor_spph }}</span></p>
            <p><span class="label">Lampiran&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                    {{ __($spph->lampiran)}} Lembar</span></p>
            </p>
            <p><span class="label">Perihal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                </span>{{ $spph->perihal }}</p>
        </div>
        <div class="address">
            <br>
            <p>Kepada Yth,</p>
            <p>
                <b>{!! nl2br($spph->penerima) !!}</b>
            </p>
            <p>{{ $spph->alamat }}</p>
        </div>
        <div style="clear: both;"></div>
        <div class="judul-konten"><u>SURAT PERMINTAAN PENAWARAN HARGA</u><br>(SPPH)</div>
        <div class="content">
            <p>Dengan Hormat,</p>
            <p style="text-align: justify">
                Memberitahukan bahwa perusahaan kami dalam waktu dekat ini bermaksud untuk melakukan pekerjaan sebagai
                tersebut :
            </p>

            <table class="table" align="center">
                <thead>
                    <tr>
                        <th style="text-align: center">No</th>
                        <th style="text-align: center">Deskripsi</th>
                        <th style="text-align: center">Spesifikasi</th>
                        <th style="text-align: center">Qty</th>
                        <th style="text-align: center">Sat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($spph->details as $item)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td style="text-align: center">{{ $item->uraian }}</td>
                            <td style="word-wrap: break-word">{{ $item->spek }}</td>
                            <td style="text-align: center">{{ $item->qty }}</td>
                            <td style="text-align: center">{{ $item->satuan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center" style="text-align: center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <p style="text-align: justify">
                Berkaitan dengan hal tersebut diatas mohon bantuannya untuk Penawaran Harga pekerjaan dimaksud.
                Jawaban atas penawaran referensi harga kami tunggu paling lambat <b>{{ $spph->batas_spph }}</b> dengan
                catatan
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
                    <td style="text-align: justify">Pembayaran 30 hari setelah barang diterima baik dan benar, serta
                        dokumen penagihan diterima
                        dengan benar & lengkap oleh PT IMSS</td>
                </tr>
            </table>

            <p>Demikian kami sampaikan, atas kerjasamanya diucapkan terima kasih.</p>
        </div>

        <div style="margin-left: 65%; width: 50%; margin-top: 5%">
            <table class="w-100">
                <tr>
                    <td class="text-center"><b>PT INKA MULTI SOLUSI SERVICE</b></td>
                </tr>
                <tr>
                    <td class="text-center" style="text-align: center"><b>KEPALA DEPARTEMEN LOGISTIK</b></td>
                </tr>
                <tr>
                    <td style="height: 70px"></td>
                </tr>
                <tr>
                    <td class="text-center" style="text-align: center"><b style="text-decoration: underline; ">(RUDI
                            HARIYANTO)</b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    {{-- <script type="text/php">
        if ( isset($pdf) ) {
            $font = Font_Metrics::get_font("helvetica", "bold");
            $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
        }
    </script> --}}
</body>

</html>
