<!DOCTYPE html>

<head>
    <title>Purchase Order</title>
    <style>
        @page {
            margin: 0px;
        }

        body {
            margin-top: 8cm;
			margin-left: 0.5cm;
			margin-right: 0.5cm;
			margin-bottom: 0.5cm;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 0.9rem;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
            padding: 20px
        }

        table,
        td,
        th {
            /* border: 1px solid black; */
        }

        .table {
            width: 100%;
            border: 1px solid black;
        }

        .table tr {
            border: 1px solid black;
            /* padding: 5px; */
        }

        td {
            padding-left: 15px;
            padding-right: 15px;
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

        header {
            position: fixed;
            top: 0.5cm;
            left: 0.5cm;
            right: 0.5cm;
            /* height: 5.5cm; */
            /* margin-bottom: 400px; */
        }

        .table2 tr  {
            border: 1px solid black;
            padding: 5px;
        }

        .alamat {
            white-space: pre-wrap;

        }
    </style>

</head>

<body>
    <header>
        <div class="information">
            <table width="100%">
                <tr>
                    <td style="text-align: left;width:33%" rowspan="11">
                        <strong>Company</strong><br>
                        <span>Aneka Filter</span><br>
                        <p class="alamat">Alamat hskdjhfkjsdfjsbfbsdbvsdhjfgruierjbsmndv nbvhg hjchdsdjfkhgirthirtuhierhtier veru</p>
                        <span>Contact</span><br>
                        <span>Telepon:</span><br>
                        <span>Fax : </span><br>
                        <span>Email : </span><br>
                    </td>
                    <td align="center" rowspan="11" style="width: 33%">
                        <img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png"
                            alt="Logo" width="250" class="logo" /><br>
                        <br><br>
                        <strong>PT INKA MULTI SOLUSI SERVICE</strong><br>
                        Salak No. 99 Madiun<br>
                        Telepon +62 812 3456789<br>
                        <br><strong style="font-size: 25">Purchase Order</strong><br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">NO PO</td>
                    <td style="text-align: left;">: <span>asddadsad</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Tanggal PO</td>
                    <td style="text-align: left;">: <span>asdasdad</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Incoterm</td>
                    <td style="text-align: left;">: <span>assadasds</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">PR NO.</td>
                    <td style="text-align: left;">: <span>assadasds</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Referensi SPH</td>
                    <td style="text-align: left;">: <span>assadasds</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">No. Justifikasi</td>
                    <td style="text-align: left;">: <span>assadasds</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">No. Negosiasi</td>
                    <td style="text-align: left;">: <span>assadasds</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Batas Akhir Po</td>
                    <td style="text-align: left;">: <span>assadasds</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Alamat Penagihan</td>
                    <td style="text-align: left;">: <span>assadasds</span></td>
                </tr>
                <tr>
                    {{-- <p style="padding: 10px" class="alamat">Alamat hskdjhfkjsdfjsbfbsdbvsdhjfgruierjbsmndv nbvhg hjchdsdjfkhgirthirtuhierhtier veru</p> --}}
                </tr>

            </table>
        </div>
    </header>
    {{-- <div style="margin-top: 400px      "></div> --}}


    <table class="table" style="margin-top: 00px">
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


    <div style="margin-top:400x">
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
        <table class="table2" style="width:100%;padding:20px">
            <tr>
                <td style="width: 16%"> 
                    <span>Referensi PO</span><br>
                    <span>Termin Pembayaran</span><br>
                    <span>Garansi</span><br>
                    <span>Proyek</span><br>
                </td>
                <td style="width: 5%">
                    <span>:</span><br>
                    <span>:</span><br>
                    <span>:</span><br>
                    <span>:</span><br>
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td style="height: 50px">Catatan Untuk Vendor</td>
                <td>:</td>
                <td></td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 1rem">
        <div style="float: left; width: 50%">
            <table class="w-100">
                <tr>
                    <td class="text-center">Disetujui Oleh</td>
                </tr>
                <tr>
                    <td style="height: 50px"></td>
                </tr>
                
            </table>
        </div>
        <div style="margin-left: 50%; width: 50%; margin-top: 5%">
            <table class="w-100">
                <tr>
                    <td class="text-center">PT INKA MULTI SOLUSI SERVIS</td>
                </tr>
                <tr>
                    <td style="height: 50px"></td>
                </tr>
                <tr>
                    {{-- <td class="text-center"><b style="text-decoration: underline">
                            &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&emsp;&emsp;&emsp;&emsp;</b>
                    </td> --}}
                    <td class="text-center" style="text-align: center"><b style="text-decoration: underline; ">Budi Harianto</b>
                    </td>
                </tr>
                <tr>
                    <td class="text-center" style="text-align: center"><b>PLT KADEP LOGISTIK</b></td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
