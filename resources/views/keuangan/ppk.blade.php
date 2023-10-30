<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Pengeluaran Kas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 210mm; /* Ukuran A4 */
            height: 297mm; /* Ukuran A4 */
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

        /* .request-type {
            float: right;
        } */

        .info {
            margin-top: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        .approval-info {
            margin-top: 20px;
        }

        .approval-info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .totals {
            margin-top: 20px;
        }

        .totals table {
            width: 100%;
            border: none;
        }

        .totals th, .totals td {
            border: none;
            padding: 8px;
            text-align: left;
        }

        .signatures {
            display: flex;
            margin-top: 20px;
        }

        .signatures p {
            flex-grow: 1;
            text-align: center;
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
            margin-top: 20px;
        }

        .authorizer p {
            margin: 5px 0;
        }

        .verifier {
            margin-top: 20px;
        }

        .verifier p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo"><img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png"
                alt="Logo" width="150" class="company-logo" /><br></div>
            <div class="title">
                <h3>PERMINTAAN PENGELUARAN KAS</h3>
            </div>
            <div class="request-type">
                <table>
                    <tr>
                        <th>NPJK/BKM/PJP</th>
                        <th style="width: 7em"></th>
                    </tr>
                </table>
            </div>
        </div>
        <table>
            <tr>
                <td>
                        <table>
                        <div class="info">
                          <tr>No PPK:</tr><br>
                          <tr>Tanggal Pengajuan:</tr><br>
                          <tr>Tanggal Pertanggungjawaban:</tr><br>
                          <tr>Kode Proyek:</tr>
                        </div>
                        </table> 
                </td>
                <td>
                    <div class="approval-info">
                        <p>s.d 10 juta mengajukan oleh Staff.Kabag dan disetujui Kadep</p>
                        <p>s.d 10 juta s.d 20 juta mengajukan Kadep disetujui oleh Kadiv</p>
                        <p>Di atas 20 juta diajukan oleh Kadiv dan disetujui oleh Direksi</p>
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr style="background-color:#000; color:white">
                <th>No</th>
                <th>Tanggal</th>
                <th>Aktivitas/Penggunaan</th>
                <th>Rencana</th>
                <th>Realisasi</th>
            </tr>
            <!-- Isi tabel disini -->
        </table>
        <div class="totals">
            <table>
                <tr>
                    <th colspan="3">Total Nilai:</th>
                    <td>______________</td>
                    <td>______________</td>
                </tr>
                <tr>
                    <th colspan="3">Selisih Lebih (Kurang):</th>
                    <td>______________</td>
                </tr>
            </table>
        </div>
        <div class="signatures">
            <p>Tanda Tangan Permohonan PPK: ______________</p>
        </div>
        <div class="column">
            <div class="authorizer">
                <p>Yang Mengajukan</p>
                <p>Nama: ______________</p>
                <p>Tanggal: ______________</p>
                <p>Jabatan: ______________</p>
            </div>
        </div>
        <div class="column">
            <div class="verifier">
                <p>Yang Menyetujui</p>
                <p>Nama: ______________</p>
                <p>Tanggal: ______________</p>
                <p>Jabatan: ______________</p>
            </div>
        </div>
        <div class="row"></div>
    </div>
</body>
</html>