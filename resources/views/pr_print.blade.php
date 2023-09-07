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

        .table2 tr  {
            border: 1px solid black;
            padding: 5px;
        }
    </style>

</head>
<body>

<div class="information">
    <table width="100%">
        <tr width="100%">
            <td align="left" style="width: 25%;">
                <img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png" alt="Logo" width="150" class="logo"/><br>
            </td>

            <td align="center" style="width: 75%;">
                <br><strong style="font-size: 25">PURCHASE REQUEST</strong><br>
                <strong style="font-size: 25">(PR)</strong><br>
            </td>
        </tr>
        <tr>
            <td align="left" style="width: 25%;">
                <br><br>
                <strong>Kepada Yth.</strong><br>
                <strong>Dept. Logistik</strong><br>
            </td>
            </td>

            <td align="left">
                <br><br>
                <strong>Nomor*    :</strong><br>
                <strong>Tanggal* :</strong><br>
            </td>
            </td>
            <td align="left" style="width: 25%;">
                <br><br>
                <strong>Proyek   :</strong><br>
            </td>
            </td>
        </tr>
    </table>
</div>
    
    {{--
    <div class="w-100 text-center">
        <b style="text-decoration: underline"></i>PURCHASE ORDER</b><br />
    </div> --}}
    <table class="table" style="margin-top: 50px; width: 100%">
        <thead style="border: 1px solid black">
            <tr style="border: 1px solid black">
                <th>No</th>
                <th>Kode Material</th>
                <th>Uraian Barang/Jasa</th>
                <th>Spesifikasi</th>
                <th>Kuantitas</th>
                <th>Qty</th>
                <th>Sat</th>
                <th>Waktu <br> Penyelesaiaan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody style="border: 1px solid black">
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
            <tr style="border: 1px solid black">
                <td style="text-align: center;">1</td>
                <td style="text-align: center;"><span></span></td>
                <td style="text-align: center;"> </td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"> </td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
            </tr>
            <tr style="border: 1px solid black">
                <td style="text-align: center;">2</td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"> </td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"> </td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top: 1rem">
        <div>
            <table style="width: 100%">
                <tr>
                    <td align="center" style="width: 25%;">
                        Menyetujui,<br>
                        Kadiv. Wilayah II
                        <br><br><br><br>
                        <strong>HARTONO</strong><br>
                    </td>
                    </td>
        
                    <td align="center" style="width: 25%;">
                        Diperiksa Oleh<br>
                        Kadep. Rendal Wil II
                        <br><br><br><br><br>
                    </td>
                    </td>
                    <td align="center" style="width: 25%;">
                        Dibuat Oleh,<br>
                        Rendal Wil II
                        <br><br><br><br>
                        <strong>FAVA WIRA</strong><br>
                    </td>
                    </td>
                </tr>
            </table>
        </div>
    </div>


    <table class="table2" style="width:100%;padding:20px; margin-top:2rem">
        <tr>
            <td><strong>DASAR PR :</strong></td>
        </tr>
        <tr>
            <td>1. mahasiswa magang diberikan tugas dan proyek sebagai beriku</td>
        </tr>
        <tr>
            <td>2. mahasiswa magang diberikan tugas dan proyek sebagai beriku</td>
    </table>

</body>

</html>
