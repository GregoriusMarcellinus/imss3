<!DOCTYPE html>

<head>
    <title>Purchase Order</title>
    <style>
        /**
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 5.5cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 2cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 2cm;
            left: 2cm;
            right: 2cm;
            height: 5.5cm;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            /* color: white; */
            text-align: center;
            /* line-height: 1.5cm; */
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;

            /** Extra personal styles **/
            background-color: #03a9f4;
            color: white;
            text-align: center;
            line-height: 1.5cm;
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
            padding: 15px 15px 15px 15px;
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
    </style>
</head>

<body>
    @php
        $path = public_path('img/imss-remove.png');
    @endphp

    <header>
        <table style="width: 100%;">
            <tr>
                <td style="text-align: center;" rowspan="4">
                    <h3 style="margin:0px;">Rencana Pembelajaran Semester</h3>
                    <h3 style="margin:0px;">Program Studi: FFF</h3>
                    <h3 style="margin:0px;">MataKuliah DDD</h3>
                    <h3 style="margin:0px;">AAAA</h3>
                </td>
                <td style="text-align: center;" rowspan="4">
                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents($path)) }}" alt="image"
                        width="150px">
                </td>
                <td style="text-align: right;">
                    Nomor
                </td>
                <td style="text-align: left;">
                    <i>: 123123</i>
                </td>
            </tr>
        </table>
    </header>



    {{-- <body> --}}
    <div class="row" style="margin-top: 1rem">
        <table>
            {{-- <div class="row">
                <div class="col"> --}}
            <tr>
                <td>Company</td>
            </tr>
            <tr>
                <td>Nama Vendor</td>
            </tr>
            <tr>
                <td>Alamat</td>
            </tr>
            <tr>
                <td>Contact</td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td>:</td>
            </tr>
            <tr>
                <td>Fax</td>
                <td>:</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
            </tr>
            {{-- </div>
                <div class="col"> --}}
            <tr>
                <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents($path)) }}" alt="image"
                    width="150px">
            </tr>
            <tr>
                <td>PT INKA MULTI SOLUSI SERVICE</td>
            </tr>
            <tr>
                <td> Salak No. 99 Madiun</td>
            </tr>
            <tr>
                <td>Telepon +62 812 3456789</td>
            </tr>
            <tr>
                <h2>Purcahse Order</h2>
            </tr>
            {{-- </div>
                <div class="col"> --}}
            <tr>
                <td>NO PO</td>
                <td>:</td>
            </tr>
            <tr>
                <td>Tanggal PO</td>
                <td>:</td>
            </tr>
            <tr>
                <td>Incoterm</td>
                <td>:</td>
            </tr>
            <tr>
                <td>PR NO.</td>
                <td>:</td>
            </tr>
            <tr>
                <td>Referensi SPH</td>
                <td>:</td>
            </tr>
            <tr>
                <td>No. Justifikasi</td>
                <td>:</td>
            </tr>
            <tr>
                <td>No. Negosiasi</td>
                <td>:</td>
            </tr>
            <tr>
                <td>Batas Akhir Po</td>
                <td>:</td>
            </tr>
            <tr>
                <td>Alamat Penagihan</td>
                <td>:</td>
            </tr>
            {{-- </div> --}}
            {{-- </div> --}}
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
