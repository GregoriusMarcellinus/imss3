<!DOCTYPE html>

<head>
    <title>Surat Jalan</title>
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
    </style>
</head>

<body onload="window.print()">
    @php
        $path = public_path('img/imss-remove.png');
    @endphp

    {{-- <body> --}}
    <div class="row justify-content-center">
        <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents($path)) }}" alt="image" width="150px">
    </div>
    <div style="margin-top: 1rem">
        <div style="float: left; width: 45%">
            <table>
                <tr>
                    <td colspan="3">KEPADA</td>
                </tr>
                <tr>
                    <td colspan="3">Team Perawatan Perkeretaapian</td>
                </tr>
                <tr>
                    <td colspan="3">PT. IMSS Madiun</td>
                </tr>
                <tr>
                    <td colspan="3">Lokasi di Ngrombo</td>
                </tr>
            </table>
        </div>
        <div style="margin-left: 45%; width: 55%">
            <table class="table2">
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $sjn->no_sjn }}
                    </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $sjn->datetime }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="d-flex w-100 justify-content-between" style="margin-bottom:1rem;margin-top:1rem">
        {{-- <div>
            <table>
                <tr>
                    <td colspan="3">KEPADA</td>
                </tr>
                <tr>
                    <td colspan="3">Team Perawatan Perkeretaapian</td>
                </tr>
                <tr>
                    <td colspan="3">PT. IMSS Madiun</td>
                </tr>
                <tr>
                    <td colspan="3">Lokasi di Ngrombo</td>
                </tr>
            </table>
        </div>
        <div>
            <table class="table2">
                <tr>
                    <td>No. Surat Jalan</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $sjn->no_sjn }}
                    </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td colspan="2">
                        {{ $sjn->datetime }}</td>
                </tr>
            </table>
        </div> --}}
    </div>
    <div class="w-100 text-center">
        <b style="text-decoration: underline"></i>SURAT JALAN</b><br />
        <b>SJN</b>
    </div>
    <table class="table" style="margin-top: 1rem">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Spesifikasi</th>
                <th>Kode Material</th>
                <th>Qty</th>
                <th>Sat</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sjn->products as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->spesifikasi }}</td>
                    <td>{{ $item->product_code }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->nama_proyek }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="margin-top: 1rem">
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
                    <td class="text-center"><b style="text-decoration: underline"> &#8287;</b></td>
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
    </table>

</body>

</html>
