<?php

namespace App\Imports;

use App\Models\Karyawan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class KaryawanImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // dd($rows[1][3]);
        // Karyawan::create([
        //     'nip' => $rows[1][3],
        //     'nama' => $rows[1][2],
        //     'tanggal_masuk' => $rows[1][8],
            

        // ]);
        // return;
        foreach ($rows as $row){
            // dd($row[3]);
            Karyawan::create([
                'nip' => $row[2],
                'nama' => $row[1],
                'tanggal_masuk' => $row[7],
                

            ]);
        }
    }
}
