<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .receipt {
            width: 210mm; 
            height: 148mm; 
            margin: 0 auto;
            border: 0px solid #000;
            padding: 20px;
        }

        /* .company-logo {
            width: 150;
            background: url('https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png')
        } */

        .header {
            text-align: center;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 0;
        }

        .checklist {
            float: right;
        }

        .checklist label {
            margin-right: 10px;
        }

        .details {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 0px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            border-top: 2px solid #000; /* Garis atas pada header */
            border-bottom: 2px solid #000; /* Garis bawah pada header */
        }

        .totals {
            margin-top: 20px;
        }

        .totals table {
            width: 100%;
            border: none; /* Hapus garis pada total */
        }

        .totals th, .totals td {
            border: none;
            padding: 8px;
            text-align: left;
        }

        .signature {
            display: flex; /* Membuat tanda tangan sejajar dalam satu baris */
            justify-content: space-between; /* Membuat tanda tangan sejajar di antara elemen */
            margin-top: 5rem;
        }

    </style>
</head>
<body>
    <div class="receipt">
        <table width="100%">
            <tr width="100%">
                <td align="left" style="width: 25%;">
                    <img src="{{ asset('img/imss-remove.png') }}"
                        alt="Logo" width="150" class="company-logo" /><br>
                        <div class="company-logo"></div>
                </td>
                <td align="middle" style="width: 50%;">
                    <div class="header">
                    <h2>BUKTI KAS MASUK<br>Ingoing Payment Voucher</h2>
                    </div>      
                </td>
                <td><div class="checklist">
                    <label for="bukti-tf">Bukti TF</label>
                    <input type="checkbox" id="bukti-tf" name="bukti-tf">
                    <label for="scan">Scan</label>
                    <input type="checkbox" id="scan" name="scan">
                </div>
                </td>
            </tr>
            <tr>
                <td align="left" style="width: 25%; margin-bottom:2rem;">
                    <br><br>
                    Nama Bank : <span></span><br>
                    Pembayaran : <span></span><br>
                    Jumlah : <span></span><br>
                </td>

                <td colspan="2" align="left" style="width: 50%; margin-bottom:2rem;">
                    <br><br>
                    No Ref : <span></span><br>
                    Tangggal Posting : <span></span><br>
                    Tanggal Transaksi : <span></span><br>
                </td>
            </tr>
        <table style="margin-top: 2rem;">
            <tr>
                <th>Kode</th>
                <th>Rekening</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Keterangan</th>
            </tr>
            <tr>
                <td>001</td>
                <td>123-456</td>
                <td>$500.00</td>
                <td>$0.00</td>
                <td>Pembayaran Barang</td>
            </tr>
            <tr>
                <td>002</td>
                <td>789-012</td>
                <td>$0.00</td>
                <td>$500.00</td>
                <td>Biaya Pengiriman</td>
            </tr>
            <div class="totals">
                    <tr>
                        <th colspan="2">Total:</th>
                        <th>$500.00</th>
                        <th>$500.00</th>
                        <th></th>
                    </tr>
            </div>
        </table>
        <div class="signature">
            <div>Kabag Akuntansi : _______________________</div>
            <div>Book Keeper     : _______________________</div>
        </div>
    </div>
</body>
</html>