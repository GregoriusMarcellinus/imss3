<?php

namespace App\Imports;

use App\Models\Aset;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class AsetImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        // return $collection;
        dd($rows);  
        foreach ($rows as $row) 
        {
            dd($row);
            // Aset::create([
            //     'nomor_aset' => $row[0],
            //     'aset_id' => $row[1],
            //     'jenis_aset' => $row[2],
            //     'merek' => $row[3],
            //     'no_seri' => $row[4],
            //     'kondisi' => $row[5],
            //     'tahun_perolehan' => $row[6],
            //     'pengguna' => $row[7],
            //     'keterangan' => $row[8],
            // ]);
        }
    }
}
