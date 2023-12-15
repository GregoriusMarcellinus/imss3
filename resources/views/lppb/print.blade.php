<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0cm;
        }

        body {
            margin-top: 9cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0.5cm;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 0.95rem;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
            padding: 10px;
        }

        td {
            padding-left: 10px;
            padding-right: 10px;
        }

        th {
            padding: 15px 15px 15px 25px;
        }

        .table {
            width: 100%;
            border: 1px solid black;
        }

        .table tr,
        .table th,
        .table td {
            border: 1px solid black;
        }

        .page-break {
            page-break-after: always;
        }

        .pagenum:before {
            content: counter(page);
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

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            /* height: 5cm; */
        }

        .header-table th {
            border-bottom: 1px solid black;
        }

        .header-table td {
            padding: 5px;
        }

        .table2 tr {
            border: 1px solid black;
            padding: 5px;
        }

        .alamat {
            white-space: pre-wrap;
        }

        .title-header {
            margin-top: 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
            right: 0;
            text-align: right;
        }

        .signature {
            text-align: center;
        }

        .no-border {
            border: none;
        }
    </style>
</head>

<body>
    <header>
        <table class="header-table" style="width: 100%; border:1px solid black;">
            <tr>
                <td align="center" style="width:33%; border:1px solid black;">
                    <img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png"
                        alt="Logo" class="logo" width="250"/>
                </td>
                <td align="center" style="vertical-align: top; width:33%; border:1px solid black;">
                    <br><br>
                    <strong style="font-size: 25">LAPORAN PEMERIKSAAN & PENERIMAAN<br>BARANG</strong>
                </td>
                <td style="width:33%; border:1px solid black;">
                    <table>
                        <tr>
                            <td>Nomor</td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td>No PO</td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td>Proyek</td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td>Halaman</td>
                            <td>: </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </header>
    <span>Diterima dari : <br>PEMBELIAN LANGSUNG <br> Dunia Terpal <br></span>
    <span>Barang-barang dengan kualitas dan kuantitas seperti tersebut dibawah</span>
    <table class="table" style="width: 100%">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama & Spesifikasi Barang</th>
                <th rowspan="2">Kode<br>Barang</th>
                <th rowspan="2">Satuan</th>
                <th colspan="2">Kuantitas</th>
                <th colspan="2">Hasil Pemeriksaan</th>
                <th rowspan="2">Sudah<br>Diterima</th>
                <th rowspan="2">Belum<br>Diterima</th>
                <th rowspan="2">Keterangan</th>
            </tr>
            <tr>
                <th>PO</th>
                <th>Penerimaan</th>
                <th>Baik</th>
                <th>Tidak Baik</th>
            </tr>
            <tr>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
            </tr>
        </thead>
        <tbody>
            {{-- @forelse ($po->details as $item)
                @php
                    $harga_per_unit = $item->harga_per_unit ?? 0;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_material }}</td>
                    <td>{{ $item->uraian }}</td>
                    <td style="text-align: center;">{{ $item->batas ? date('d/m/Y', strtotime($item->batas)) : '-' }}
                    <td style="text-align: center;">{{ $item->qty }}</td>
                    <td style="text-align: center;">{{ $item->satuan }}</td>
                    <td style="text-align: center;">@rupiah($harga_per_unit)</td>
                    <td style="text-align: center;">{{ $item->mata_uang ?? '-' }}</td>
                    <td style="text-align: center;">{{ $item->vat ?? '-' }}</td>
                    <td style="text-align: center;">@rupiah($item->qty * $item->harga_per_unit)</td>
                </tr>
            @empty --}}
            <tr>
                <td colspan="11" style="text-align: center">Tidak ada data</td>
            </tr>
            {{-- @endforelse --}}
        </tbody>
    </table>

    <div class="footer">
        <div style="width: 50%;">
            <table class="no-border">
                <tr>
                    <td class="signature">
                        <b style="text-decoration: underline;">
                            AMRON BAITARRIZAQ
                        </b><br>KEPALA DIVISI TEKNIK & LOGISTIK
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
