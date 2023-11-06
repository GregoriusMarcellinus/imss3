<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1024px, initial-scale=1">
    <title>Slip Gaji</title>
    <style>
        @page {
            size: portrait;
            /* size: landscape; */
        }

        body {
            margin: 0;
        }

        * {
            font-size: 0.8rem;
        }

        .salary-slip {
            margin: 15px;
            text-align: left;
        }

        .empDetail {
            width: 100%;
            text-align: left;
            border: 2px solid black;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .head {
            margin: 10px;
            margin-bottom: 50px;
            width: 100%;
        }

        .companyName {
            text-align: left;
            font-size: 25px;
            font-weight: bold;
        }

        .salaryMonth {
            text-align: left;
        }

        .table-border-bottom {
            border-bottom: 1px solid;
        }

        .table-border-right {
            border-right: 1px solid;
        }

        .myBackground {
            padding-top: 10px;
            text-align: left;
            border: 1px solid black;
            height: 40px;
            background-color: #c2d69b;
        }

        .myAlign {
            text-align: left;
            border-right: 1px solid black;
        }

        .myTotalBackground {
            padding-top: 10px;
            text-align: left;
            background-color: #EBF1DE;
            border-spacing: 0px;
        }

        .align-4 {
            width: 25%;
            float: right;
        }

        .tail {
            margin-top: 35px;
        }

        .align-2 {
            margin-top: 25px;
            width: 50%;
            float: left;
        }

        .border-center {
            text-align: left;
        }

        .border-center th,
        .border-center td {
            border: 1px solid black;
        }

        th,
        td {
            padding-left: 6px;
        }
    </style>
</head>

<body>
    <div class="salary-slip">
        <table class="empDetail">
            <tr style="height: 20rem">
                <td colspan='4'>
                    <img height="50px" src="https://ptrekaindo.co.id/wp-content/uploads/2019/07/Logo-Reka-1000.png">
                </td>
                <td colspan='4' class="companyName">SLIP GAJI JUNI 2023</td>
            </tr>
            <tr>
                <th style="text-align: left">
                    Name
                </th>
                <td>
                    Example
                </td>
                <td></td>
                <td></td>
                <th>
                    Bank Code
                </th>
                <td>
                    ABC123
                </td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th style="text-align: left">
                    Employee Code
                </th>
                <td>
                    XXXXXXXXXXX
                </td>
                <td></td>
                <td></td>
                <th>
                    Bank Name
                </th>
                <td>
                    XXXXXXXXXXX
                </td>
                <td></td>
                <td class="table-border-left"></td>
            <tr class="myBackground">
                <th colspan="2" style="text-align: left">
                    PENDAPATAN
                </th>
                <th>
                </th>
                <th class="table-border-right">
                    JUMLAH (Rp.)
                </th>
                <th colspan="2" style="text-align: left">
                    POTONGAN
                </th>
                <th>
                </th>
                <th>
                    JUMLAH (Rp.)
                </th>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left">
                    1. GAJI POKOK
                </td>
                <td></td>
                <td class="myAlign">
                    4935.00
                </td>
                <td colspan="2" style="text-align: left">
                    1. POT. BPJS KETENAGA KERJAAN JHT
                </td>
                <td></td>

                <td class="myAlign">
                    00.00
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left">
                    2. TUNJANGAN TETAP
                </td>
                <td></td>

                <td class="myAlign">
                    00.00
                </td>
                <td colspan="2" style="text-align: left">
                    2. POT. BPJS KESEHATAN
                </td>
                <td></td>

                <td class="myAlign">
                    00.00
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left">
                    3. TUNJANGAN PROFESIONAL (PKWT)
                </td>
                <td></td>

                <td class="myAlign">
                    00.00
                </td>
                <td colspan="2" style="text-align: left">
                    3. POT. PPIP
                </td>
                <td></td>

                <td class="myAlign">
                    00.00
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left">
                    4. TUNJANGAN TRANSPORTASI
                </td>
                <td></td>
                <td class="myAlign">
                    00.00
                </td>
                <td colspan="2" style="text-align: left">
                    4. POT. KEUANGAN
                </td>
                <td></td>
                <td class="myAlign">
                    00.00
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left">
                    5. TUNJANGAN KARYA
                </td>
                <td></td>

                <td class="myAlign">
                    00.00
                </td>
                <td colspan="2" style="text-align: left">
                    5. POT. KOPINKA
                </td>
                <td></td>

                <td class="myAlign">
                    00.00
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left">
                    6. TUNJANGAN TRANSISI/RAPEL
                </td>
                <td></td>
                <td class="myAlign">
                    00.00
                </td>
                <td colspan="2" style="text-align: left">
                    6. JAM HILANG/PENYESUAIAN
                </td>
                <td></td>
                <td class="myAlign">
                    00.00
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left;">
                    7. BENEFIT
                    {{-- <ul style="list-style: none;">
                        <li>
                            BPJS KETENAGAKERJAAN
                            <ul style="list-style: none">
                                <li>JKK</li>
                                <li>JKM</li>
                                <li>JHT</li>
                                <li>JP</li>
                            </ul>
                        </li>
                        <li>BPJS KESEHATAN</li>
                        <li>PPIP</li>
                        <li>JUMLAH PREMI</li>
                    </ul> --}}
                </td>
                <td></td>
                <td class="myAlign">

                </td>
                <td colspan="2"style="text-align: left;vertical-align:top;">
                    7. BENEFIT
                </td>
                <td></td>
                <td class="myAlign" style="vertical-align:top;">
                    00.00
                </td>
            </tr>
            <tr>
                <td colspan="2">
                <ul style="list-style: none;padding-left: 15%;margin: 0%">
                    <li>
                        BPJS KETENAGAKERJAAN
                        <ul style="list-style: none;padding-left: 15%;">
                            <li>JKK</li>
                            <li>JKM</li>
                            <li>JHT</li>
                            <li>JP</li>
                        </ul>
                    </li>
                    <li>BPJS KESEHATAN</li>
                    <li>PPIP</li>
                    <li>JUMLAH PREMI</li>
                </ul>
                </td>
                <td  style="text-align: left;"></td>
                <td class="table-border-right"></td>
                <td ></td>
                <td ></td>
                <td ></td>
                <td ></td>
            </tr>
            <tr class="myBackground">
                <th colspan="3" style="text-align: left">
                    JUMLAH PENDAPATAN BRUTO
                </th>
                <td class="myAlign">
                    10000
                </td>
                <th colspan="3" style="text-align: left">
                    JUMLAH POTONGAN
                </th>
                <td class="myAlign">
                    1000
                </td>
            </tr>
            <tr height="40px">
                <td colspan="2" class="table-border-bottom" style="text-align: left">
                    <b>PENDAPATAN NETTO</b>
                </td>
                <td></td>
                <td class="table-border-right">
                    XXXXXXX
                </td>
                <td colspan="4" style="text-align: center">
                    Madiun, 21 September 2023
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: left">
                    Saldo PPIP (PKWT)
                </td>
                <td></td>
                <td class="table-border-right">
                    00.00
                </td>
                <td colspan="4" style="text-align: center;">
                    Presiden Direktur
                </td>
            </tr>
            <tr>
                <td colspan="2" style="vertical-align: top">
                    Nilai Kredit Poin
                </td>
                <td></td>
                <td class="myAlign" style="vertical-align: top">
                    00.00
                </td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="2" style="vertical-align: top">
                    Nilai IKK
                </td>
                <td></td>
                <td class="myAlign" style="vertical-align: top">
                    00.00
                </td>
                <td colspan="4" style="text-align: center; height: 50px;vertical-align: bottom;">
                    <b><u> A. Wishnudartha Pagehgiri </u></b>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
