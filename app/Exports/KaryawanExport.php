<?php

namespace App\Exports;

use App\Models\Karyawan;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KaryawanExport implements FromView, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Karyawan::all();
    // }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function view(): View
    {
        $items = Karyawan::all();
        foreach ($items as $item) {
           
            // Convert the tanggal_masuk to a Carbon instance
            $tanggalMasuk = Carbon::parse($item->tanggal_masuk);
        
            // Calculate the difference in years and months
            $difference = $tanggalMasuk->diff(Carbon::now());
            $lamaBekerjaTahun = $difference->y;
            $lamaBekerjaBulan = $difference->m;

            //usia
            $tanggalLahir = Carbon::parse($item->tanggal_lahir);
        
            // Calculate the difference in years and months
            $differenceLahir = $tanggalLahir->diff(Carbon::now());
            $usiaTahun = $differenceLahir->y;
            $usiaBulan = $differenceLahir->m;
            $usia = "$usiaTahun tahun $usiaBulan bulan";
        
            // Add the calculated values to the item
            $item->tanggal_masuk = Carbon::parse($item->tanggal_masuk)->isoFormat('D MMMM Y');
            $item->tanggal_pengangkatan_atau_akhir_kontrak = Carbon::parse($item->tanggal_pengangkatan_atau_akhir_kontrak)->isoFormat('D MMMM Y');
            $item->tanggal_lahir = Carbon::parse($item->tanggal_lahir)->isoFormat('D MMMM Y');

            //jika item berbeda menggunakan tanda tanya(?) lalu titik dua (:) trus else / isi nya
            $item->pensiun =  $item->pensiun ? Carbon::parse($item->pensiun)->isoFormat('D MMMM Y') : "";

            $item->lama_bekerja_tahun = $lamaBekerjaTahun;
            $item->lama_bekerja_bulan = $lamaBekerjaBulan;
            $item->usia = $usia;
        }
        return view('karyawan.export', [
            'items' => $items
        ]);
    }
}
