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
            /* width: 210mm; Lebar A5 dalam mode landscape
            height: 148mm; Tinggi A5 dalam mode landscape */
            margin: 0 auto;
            border: 1px solid #000;
            padding: 20px;
            /* transform: rotate(-90deg); /* Untuk mode landscape
            transform-origin: left top; Atur rotasi dari kiri atas */
        }

        .company-logo {
            width: 80px;
            height: 80px;
            background: url('logo-perusahaan.jpg') center/cover no-repeat;
        }

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
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        .totals {
            margin-top: 20px;
        }

        .signature {
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="receipt">
        <table width="100%">
            <tr width="100%">
                <td align="left" style="width: 25%;">
                    <img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png"
                        alt="Logo" width="150" class="logo" /><br>
                </td>
                <td align="center" style="width: 50%;">
                    <div class="company-logo"></div>
                    <div class="header">
                    <h2>BUKTI KAS MASUK</h2>
                    <p>Ingoing Payment Voucher</p>
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
                <td align="left" style="width: 25%;">
                    <br><br>
                    Nama Bank : <span></span><br>
                    Pembayaran : <span></span><br>
                    Jumlah : <span></span><br>
                </td>

                <td align="center">
                    <br><br>
                    No Ref : <span></span><br>
                    Tangggal Posting : <span></span><br>
                    Tanggal Transaksi : <span></span><br>
                </td>
            </tr>
        {{-- <div class="company-logo"></div>
        <div class="header">
            <h2>BUKTI KAS MASUK</h2>
            <p>Ingoing Payment Voucher</p>
        </div>
        <div class="checklist">
            <label for="bukti-tf">Bukti TF</label>
            <input type="checkbox" id="bukti-tf" name="bukti-tf">
            <label for="scan">Scan</label>
            <input type="checkbox" id="scan" name="scan">
        </div>
        <div class="details">
            <p>Nama Bank: Bank ABC</p>
            <p>Keterangan Pembayaran: Pembayaran Barang Jasa</p>
            <p>Jumlah: $1,000.00</p>
            <p>Nomor Ref: 123456789</p>
            <p>Tanggal Posting: 2023-10-26</p>
            <p>Tanggal Transaksi: 2023-10-25</p>
        </div> --}}
        <table>
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
        </table>
        <div class="totals">
            <p>Total Debit: $500.00</p>
            <p>Total Kredit: $500.00</p>
        </div>
        <div class="signature">
            <p>Tanda Tangan Penerima: _______________________</p>
            <p>Tanda Tangan Pemberi: _______________________</p>
        </div>
    </div>
</body>
</html>