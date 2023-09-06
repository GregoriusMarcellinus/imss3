<!DOCTYPE html>

<head>
    <title>Purchase Order {{$po->nama_proyek ?? "-"}}</title>
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
            padding-left: 10px;
            padding-right: 10px;
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
            top: 0.1cm;
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
                    <td style="text-align: left;width:33%;" rowspan="12">
                        <strong>Company</strong><br>
                        <span>{{$po->nama_vendor}}</span><br>
                        <p class="alamat">{{$po->alamat_vendor ?? "-"}}</p>
                        <span>Contact</span><br>
                        <span>Telepon&nbsp;&nbsp;&nbsp;&nbsp;: {{$po->telp_vendor ?? "-"}}</span><br>
                        <span>Fax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$po->fax_vendor ?? "-"}}</span><br>
                        <span>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$po->email_vendor ?? "-"}}</span><br>
                    </td>
                </tr>
                <tr>
                    <td align="center" rowspan="12" style="width: 33%">
                        <img src="https://inkamultisolusi.co.id/api_cms/public/uploads/editor/20220511071342_LSnL6WiOy67Xd9mKGDaG.png"
                            alt="Logo" width="250" class="logo" /><br>
                        <br><br>
                        <strong>PT INKA MULTI SOLUSI SERVICE</strong><br>
                        Jl Salak No. 99 Madiun 63131-Indonesia<br>
                        Telepon +62 812 3456789<br>
                        <br><strong style="font-size: 25">Purchase Order</strong><br>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">NO PO</td>
                    <td style="text-align: left;">: <span>{{$po->no_po}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Tanggal PO</td>
                    <td style="text-align: left;">: <span>{{$po->tanggal_po}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Incoterm</td>
                    <td style="text-align: left;">: <span>{{$po->incoterm}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">PR NO.</td>
                    <td style="text-align: left;">: <span>{{$po->pr_no ?? "-"}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Referensi SPH</td>
                    <td style="text-align: left;">: <span>{{$po->ref_sph ?? "-"}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">No. Justifikasi</td>
                    <td style="text-align: left;">: <span>{{$po->no_just ?? "-"}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">No. Negosiasi</td>
                    <td style="text-align: left;">: <span>{{$po->no_nego ?? "-"}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;">Batas Akhir Po</td>
                    <td style="text-align: left;">: <span>{{$po->batas_po}}</span></td>
                </tr>
                <tr>
                    <td style="text-align: left;vertical-align: top;">Alamat Penagihan</td>
                    <td style="text-align: left;">: <span>  Direktur Keuangan, SDM, dan Manris PT INKA Multi Solusi Servis Jl Salak No. 59 Madiun <br> N.P.W.P : 70.9607.6574.576.5</span></td>
                </tr>

            </table>
        </div>
    </header>
    {{-- <div style="margin-top: 400px"></div> --}}

    <table class="table" style="max-width: 90%">
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
            {{-- @foreach ($po as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_material }}</td>
                    <td>{{ $item->deskripsi }}</td>
                    <td>{{ $item->batas_akhir_diterima }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->harga_per_unit }}</td>
                    <td>{{ $item->mata_uang }}</td>
                    <td>{{ $item->vat }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach --}}
            
            <tr>
                <td style="text-align: center;">1</td>
                <td style="text-align: center;"><span></span></td>
                <td style="text-align: center;"> </td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"> </td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span></span></td>
            </tr>
            <tr>
                <td style="text-align: center;">2</td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"> </td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"> </td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
                <td style="text-align: center;"><span> </span></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top:400x">
        <div style="margin-top: 1rem">
            <div style="margin-left: 70%; width: 50%">
                <table class="w-100">
                    <tr>
                        <td>Sub Total</td>
                        <td>:</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Ongkos Kirim</td>
                        <td>:</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Asuransi</td>
                        <td>:</td>
                        <td>0</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>:</td>
                        <td>0</td>
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
                <td style="width: 1%">
                    <span>:</span><br>
                    <span>:</span><br>
                    <span>:</span><br>
                    <span>:</span><br>
                </td>
                <td>
                    <span>{{$po->ref_po}}</span><br>
                    <span>{{$po->term_pay}}</span><br>
                    <span>{{$po->garansi}}</span><br>
                    <span>{{$po->nama_proyek}}</span><br>
                </td>
            </tr>
            <tr>
                <td style="height: 50px;vertical-align: top;">Catatan Untuk Vendor</td>
                <td style="vertical-align: top;">:</td>
                <td></td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 1rem">
        <div style="float: left; width: 50%">
            <table class="w-100">
                <tr>
                    <td class="text-center">Disetujui Oleh,</td>
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
                    <td style="height: 100px"></td>
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
