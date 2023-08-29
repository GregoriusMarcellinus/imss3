<!DOCTYPE html>

<head>
    <title>Purchase Order</title>
    <style>    
    @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            border-collapse: collapse;
        }

        table,
        td,
        th {
            /* border: 1px solid black; */
        }

        td {
            padding-left: 15px;
            padding-right: 15px;
        }

        thead {
            background-color: #f2f2f2;
        }

        th {
            padding: 15px 15px 15px 25px;
        }

        .page_break {
            page-break-before: always;
        }

        .td-no-top-border {
            border-top: 1px solid transparent !important;
        }

        .td-no-left-right-border {
            border-left: 1px solid transparent !important;
            border-right: 1px solid transparent !important;
        }

        .td-no-left-border {
            border-left: 1px solid transparent !important;
        }

        .pagenum:before {
            content: counter(page);
        }
        }
        .invoice table {
            margin: 15px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            color: #000000;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr>
            <td align="left" style="width: 25%;">
                <h3>Company :</h3>
                <pre>Nama Vendor:
Alamat:
Contact:
<br><br>
Telepon:
Fax:
Email:
</pre>


            </td>
            <td align="center">
                <img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png" alt="Logo" width="200" class="logo"/><br>
                <br><br>
                <strong>PT INKA MULTI SOLUSI SERVICE</strong><br>
                Salak No. 99 Madiun<br>
                Telepon +62 812 3456789<br>
                <br><strong style="font-size: 25">Purchase Order</strong><br>
            </td>
            <td align="left" style="width: 25%;">
                <pre>NO PO:
Tanggal PO:
Incoterm:
PR NO.:
Referensi SPH:
No. Justifikasi:
No. Negosiasi:
Batas Akhir Po:

Alamat Penagihan:
                </pre>
            </td>
        </tr>

    </table>
</div>
    
    {{--
    <div class="w-100 text-center">
        <b style="text-decoration: underline"></i>PURCHASE ORDER</b><br />
    </div> --}}
    <table class="table" style="margin-top: 1rem">
        <thead>
            <tr>
                <th>Item</th>
                <th>Kode Material</th>
                <th>Deskripsi</th>
                <th>Batas Akhir Diterima</th>
                <th>Kuantitas</th>
                <th>Unit</th>
                <th>Harga Per Unit</th>
                <th>Mata Uang</th>
                <th>Vat</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($sjn->products as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->spesifikasi }}</td>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->nama_proyek }}</td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>
    <div style="margin-top: 1rem">
        <div style="margin-left: 50%; width: 50%">
            <table class="w-100">
                <tr>
                    <td>Sub Total</td>
                </tr>
                <tr>
                    <td>Ongkos Kirim</td>
                </tr>
                <tr>
                    <td>Asuransi</td>
                </tr>
                <tr>
                    <td>Total</td>
                </tr>
            </table>
        </div>
    </div>


    <table class="table2" style="margin-top:2rem">
        <tr>
            <td>Referensi PO</td>
            <td>:</td>
            <td><span>axx</span></td>
        </tr>
        <tr>
            <td>Termin Pembayaran</td>
            <td>:</td>
            <td><span>axx</span></td>
        </tr>
        <tr>
            <td>Garansi</td>
            <td>:</td>
            <td><span>axx</span></td>
        </tr>
        <tr>
            <td>Proyek</td>
            <td>:</td>
            <td><span>axx</span></td>
        </tr>
        <tr>
            <td>Catatan Untuk Vendor</td>
            <td>:</td>
            <td><span>axx</span></td>
        </tr>
    </table>

</body>

</html>
