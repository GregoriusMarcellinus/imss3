<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Pengeluaran Kas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 210mm;
            /* Ukuran A4 */
            height: 297mm;
            /* Ukuran A4 */
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
        }

        .logo {
            width: 50px;
        }

        .title {
            margin-left: 5rem;
            text-align: center;
            flex-grow: 1;
        }

        .info {
            margin-top: 15px;
        }

        .info p {
            margin: 3px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .border-table,
        .border-table th,
        .border-table td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .approval-table {
            width: 100%;
            border-collapse: collapse;
        }

        .approval-table th {
            text-align: center;
            padding: 8px;
            border-bottom: 1px solid #000;
        }

        .approval-table td {
            text-align: center;
            padding: 8px;
            border: none;
            /* Menghapus garis pada sel data */
        }

        .column {
            float: left;
            width: 50%;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .authorizer {
            margin-bottom: 25px;
        }

        .authorizer p {
            margin: 2px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo"><img
                    src="{{ asset('img/imss-remove.png') }}"
                    alt="Logo" width="150" class="company-logo" /><br></div>
            <div class="title">
                <h2>PERMINTAAN PENGELUARAN KAS</h2>
            </div>
            <div class="request-type">
                <table class="border-table">
                    <tr>
                        <th>NPJK/BKM/PJP</th>
                        <th style="width: 7em"></th>
                    </tr>
                </table>
            </div>
        </div>
        <table class="border-table" width: 100%>
            <tr>
                <td style="width: 50%">
                    <div class="info">
                        <p style="margin-top: 20px;">NO PPK :</p>
                        <p style="margin-top: 20px;">TANGGAL PENGAJUAN :</p>
                        <p style="margin-top: 20px;">TANGGAL PERTANGGUNGJAWABAN :</p>
                        <p style="margin-top: 20px;">KODE PROYEK :</p>
                    </div>
                </td>
                <td>
                    <table style="margin-top: 10px" class="approval-table">
                        <tr style="text-align: left; border: 0px solid #000;">
                            <b>Batasan Pengajuan & Persetujuan PPK</b>
                        </tr>
                        <tr style="border-collapse: collapse">
                            <th>Batasan</th>
                            <th>Mengajukan</th>
                            <th>Menyetujui</th>
                        </tr>
                        <tr>
                            <td>s.d 10 juta</td>
                            <td>Staff.Kabag</td>
                            <td>Kadep</td>
                        </tr>
                        <tr>
                            <td>s.d 10 juta s.d 20 juta</td>
                            <td>Kadep</td>
                            <td>Kadiv</td>
                        </tr>
                        <tr>
                            <td>Di atas 20 juta</td>
                            <td>Kadiv</td>
                            <td>Direksi</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table style="margin-top: 20px" class="border-table">
            <tr style="background-color:#000; color:white;">
                <th style="text-align: center">NO</th>
                <th style="text-align: center">TANGGAL</th>
                <th style="text-align: center">AKTIVITAS/PENGGUNAAN</th>
                <th style="text-align: center">RENCANA</th>
                <th style="text-align: center">REALISASI</th>
            </tr>
            <!-- Isi tabel disini -->
            <div class="totals">
                <tr>
                    <th style="text-align: center" colspan="3">TOTAL NILAI:</th>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th style="text-align: center" colspan="3">SELISIH LEBIH(KURANG):</th>
                    <td></td>
                </tr>
            </div>
        </table>
        <table style="margin-top: 20px" class="border-table">
            <tr style="background-color:#000; color:white">
                <th style="text-align: center; margin: 0;" colspan="4">PERMOHONAN PPK</th>
            </tr>
            <tr>
                <td style="text-align: center; margin: 0;" colspan="2"><b>RENCANA</b></td>
                <td style="text-align: center; margin: 0;" colspan="2"><b>REALISASI</b></td>
            </tr>
            <tr>
                <td style="text-align: center; margin: 0;"><b>YANG MENGAJUKAN</b></td>
                <td style="text-align: center; margin: 0;"><b>YANG MENYETUJUI</b></td>
                <td style="text-align: center; margin: 0;"><b>YANG MENGAJUKAN</b></td>
                <td style="text-align: center; margin: 0;"><b>YANG MENYETUJUI</b></td>
            </tr>
            <tr>
                <td>
                    <div class="column">
                        <div class="authorizer">
                            <p>Nama: </p>
                            <p>NIP: </p>
                            <p>Tanda Tangan: </p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="column">
                        <div class="authorizer">
                            <p>Nama: </p>
                            <p>NIP: </p>
                            <p>Tanda Tangan: </p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="column">
                        <div class="authorizer">
                            <p>Nama: </p>
                            <p>NIP: </p>
                            <p>Tanda Tangan: </p>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="column">
                        <div class="authorizer">
                            <p>Nama: </p>
                            <p>NIP: </p>
                            <p>Tanda Tangan: </p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="border-table">
            <tr style="background-color:#000; color:white">
                <th style="text-align: center; margin: 0;" colspan="4">OTORISATOR PENGELUARAN UANG</th>
            </tr>
            <tr>
                <td style="vertical-align: text-top; margin: 0;" rowspan="4">
                    <h4>Otorisasi Pengesahan Pembayaran</h4><br><br>
                    <p>Kadep Keuangan : s.d Rp10 Juta </p>
                    <p>Kadiv Keuangan : Rp10 Juta s.d Rp20 Juta </p>
                    <p style="margin-bottom: 5rem">Direktur Keuangan, SDM, & Manrisk : diatas Rp20 Juta </p>
                </td>
                <td style="text-align: center; margin: 0;"><b>PEJABAT</b></td>
                <td style="text-align: center; margin: 0;"><b>TANGGAL</b></td>
                <td style="text-align: center; margin: 0;"><b>TANDA TANGAN</b></td>
            </tr>
            <tr>
                <td><b>
                    <p style="margin: 0">Kadep Keuangan </p><br>
                    <p>Nama : </p>
                    <p style="margin-bottom: 0">NIP: </p></b>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>
                    <p style="margin: 0">Kadiv Keuangan </p><br>
                    <p>Nama : </p>
                    <p style="margin-bottom: 0">NIP: </p></b>
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b><p style="margin: 0">Direktur Keuangan, SDM, & Manrisk </p><br>
                    <p>Nama : </p>
                    <p style="margin-bottom: 0">NIP: </p></b>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <table class="border-table">
            <tr style="background-color:#000; color:white">
                <th style="text-align: center" colspan="4">VERIFIKATOR PENGELUARAN UANG</th>
            </tr>
            <tr>
                <td style="width: 35%"></td>
                <td style="text-align: center; margin: 0;"><b>RENCANA</b></td>
                <td style="text-align: center; margin: 0;"><b>REALISASI</b></td>
                <td style="text-align: center; margin: 0;"><b>KETERANGAN</b></td>
            </tr>
            <tr>
                <td><b>
                    <p style="margin: 0">Kadiv Keu/Kadep Akuntansi/Verifikator </p><br>
                    <p style="margin-bottom: 0">Nama/NIP: </p></b>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>
                    <p style="margin: 0">Dibayar oleh Bendahara </p><br>
                    <p style="margin-bottom: 0">Nama/NIP: </p></b>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b><p style="margin: 0">Diterima Oleh </p><br>
                    <p style="margin-bottom: 0">Nama/NIP: </p></b>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <div class="row"></div>
    </div>
</body>

</html>
