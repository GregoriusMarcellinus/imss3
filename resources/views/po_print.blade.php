<!DOCTYPE html>

<head>
    <title>Purchase Order</title>
    <style>
        table {
            border-collapse: collapse;
            /* border: 2px solid rgb(200, 200, 200); */
            /* letter-spacing: 1px; */
            font-size: 0.8rem;
        }

        .table {
            border-collapse: collapse;
            border: 1px solid black;
            letter-spacing: 1px;
            font-size: 0.8rem;
            width: 100%;
        }

        .table2 {
            border-collapse: collapse;
            border: 1px solid black;
            letter-spacing: 1px;
            font-size: 0.8rem;
            width: 100%;
        }

        .table td,
        .table th {
            border: 1px solid black;
            padding: 10px 20px;
        }

        .table2 td,
        .table2 th {
            padding: 2px 5px;
        }

        .table th {
            background-color: white;
        }


        .td-border {
            border: 1px solid black;
        }

        .w-100 {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        
        .d-flex {
            display: flex;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        /* buat css untuk membagi tabel tr jadi tiga kolom */
        .col {
            width: 33.33%;
            float: left;
        }

        /* buat css untuk mengatur margin dan padding */
        .row {
            margin-left: 5px;
            margin-right: 5px;
        }

        
    </style>
</head>

<body onload="window.print()">
    @php
        $path = public_path('img/imss-remove.png');
    @endphp

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
    {{-- <div style="margin-top: 1rem">
        <div style="float: left; width: 50%">
            <table class="w-100">
                <tr>
                    <td class="text-center">Pengirim</td>
                </tr>
                <tr>
                    <td style="height: 50px"></td>
                </tr>
                <tr>
                    <td class="text-center"><b style="text-decoration: underline">{{ __($sjn->nama_pengirim) }}</b>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-left: 50%; width: 50%">
            <table class="w-100">
                <tr>
                    <td class="text-center">Penerima</td>
                </tr>
                <tr>
                    <td style="height: 50px"></td>
                </tr>
                <tr>
                    <td class="text-center"><b style="text-decoration: underline">
                            &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&emsp;&emsp;&emsp;&emsp;</b>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <table style="margin-top:2rem">
        <tr>
            <td colspan="3">Note</td>
        </tr>
        <tr>
            <td colspan="3">1. Sesuai BPM No.019/BPM/PPO/I/2023</td>
        </tr>
        <tr>
            <td colspan="3">2. <b>Lembar Warna PUTIH & KUNING di kembalikan di PT IMSS, Madiun</b></td>
        </tr>
        <tr>
            <td colspan="3"><b>Kantor Pusat : Jl. Salak No 99 Madiun, Telp (08351)454094, email:
                    imsservice14@gmail.com</b></td>
        </tr>
    </table> --}}

</body>

</html>
