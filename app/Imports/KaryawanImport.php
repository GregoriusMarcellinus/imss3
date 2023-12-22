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
        // dd($rows);
        unset($rows[0]);
        foreach ($rows as $row){
            
            if( $row[1] != null){
                $karyawan = Karyawan::where('nip',$row[2])->count();
                if($karyawan==0){

                    Karyawan::create([
                        'nip' => $row[2],
                        'nama' => $row[1],
                        'tanggal_masuk' => $row[7],
                        'status_pegawai' => $row[10],
                        'rekrutmen' => $row[5],
                        'domisili' => $row[6],
                        'rekening_mandiri' => $row[3],
                        'rekening_bsi' => $row[4] ?? '',
                        'sk_pengangkatan_atau_kontrak' => $row[11] ?? '',
                        'tanggal_pengangkatan_atau_akhir_kontrak' => $row[12] ?? '',
                        'jabatan_inka' => $row[13] ?? '',
                        'jabatan_imss' => $row[14] ?? '',
                        'administrasi_atau_teknisi' => $row[15] ?? '',
                        'lokasi_kerja' => $row[16] ?? '',
                        'bagian_atau_proyek' => $row[17] ?? '',
                        'departemen_atau_subproyek' => $row[18] ?? '',
                        'divisi' => $row[19] ?? '',
                        'direktorat' => $row[20] ?? '',
                        'sertifikat' => $row[21] ?? '',
                        'surat_peringatan' => $row[22] ?? '',
                        'jenis_kelamin' => $row[23] ?? '',
                        'tempat_lahir' => $row[24] ?? '',
                        'tanggal_lahir' => $row[25] ?? '',
                        'nomor_ktp' => $row[27] ?? '',
                        'alamat' => $row[28] ?? '',
                        'nomor_hp' => $row[29] ?? '',
                        'email' => $row[31] ?? '',
                        'bpjs_kesehatan' => $row[32] ?? '',
                        'bpjs_ketenagakerjaan' => $row[33] ?? '',
                        'status_pernikahan' => $row[34] ?? '',
                        'suami_atau_istri' => $row[35] ?? '',
                        'anak_ke_1' => $row[36] ?? '',
                        'anak_ke_2' => $row[37] ?? '',
                        'anak_ke_3' => $row[38] ?? '',
                        'tambahan' => $row[39] ?? '',
                        'ayah_kandung' => $row[40] ?? '',
                        'ibu_kandung' => $row[41] ?? '',
                        'ayah_mertua' => $row[42] ?? '',
                        'ibu_mertua' => $row[43] ?? '',
                        'jumlah_tanggungan' => $row[44] ?? '',
                        'status_pajak' => $row[45] ?? '',
                        'npwp' => $row[46] ?? '',
                        'agama' => $row[47] ?? '',
                        'pendidikan_diakui' => $row[48] ?? '',
                        'jurusan' => $row[49] ?? '',
                        'almamater' => $row[50] ?? '',
                        'tahun_lulus' => $row[51] ?? '',
                        'pendidikan_terakhir' => $row[52] ?? '',
                        'jurusan_terakhir' => $row[53] ?? '',
                        'almamater_terakhir' => $row[54] ?? '',
                        'tahun_lulus_terakhir' => $row[55] ?? '',
                        'mpp' => $row[56] ?? '',
                        'pensiun' => $row[57] ?? '',
                        'ukuran_baju' => $row[58] ?? '',
                        'ukuran_celana' => $row[59] ?? '',
                        'ukuran_sepatu' => $row[60] ?? '',
                        'vaksin_1' => $row[61] ?? '',
                        'vaksin_2' => $row[62] ?? '',
                        'vaksin_3' => $row[63] ?? '',
                        
        
                    ]);
                }else{
                    //update data

                    Karyawan::where('nip',$row[2])
                    ->update([
                        'nip' => $row[2],
                        'nama' => $row[1],
                        'tanggal_masuk' => $row[7],
                        'status_pegawai' => $row[10],
                        'rekrutmen' => $row[5],
                        'domisili' => $row[6],
                        'rekening_mandiri' => $row[3],
                        'rekening_bsi' => $row[4] ?? '',
                        'sk_pengangkatan_atau_kontrak' => $row[11] ?? '',
                        'tanggal_pengangkatan_atau_akhir_kontrak' => $row[12] ?? '',
                        'jabatan_inka' => $row[13] ?? '',
                        'jabatan_imss' => $row[14] ?? '',
                        'administrasi_atau_teknisi' => $row[15] ?? '',
                        'lokasi_kerja' => $row[16] ?? '',
                        'bagian_atau_proyek' => $row[17] ?? '',
                        'departemen_atau_subproyek' => $row[18] ?? '',
                        'divisi' => $row[19] ?? '',
                        'direktorat' => $row[20] ?? '',
                        'sertifikat' => $row[21] ?? '',
                        'surat_peringatan' => $row[22] ?? '',
                        'jenis_kelamin' => $row[23] ?? '',
                        'tempat_lahir' => $row[24] ?? '',
                        'tanggal_lahir' => $row[25] ?? '',
                        'nomor_ktp' => $row[27] ?? '',
                        'alamat' => $row[28] ?? '',
                        'nomor_hp' => $row[29] ?? '',
                        'email' => $row[31] ?? '',
                        'bpjs_kesehatan' => $row[32] ?? '',
                        'bpjs_ketenagakerjaan' => $row[33] ?? '',
                        'status_pernikahan' => $row[34] ?? '',
                        'suami_atau_istri' => $row[35] ?? '',
                        'anak_ke_1' => $row[36] ?? '',
                        'anak_ke_2' => $row[37] ?? '',
                        'anak_ke_3' => $row[38] ?? '',
                        'tambahan' => $row[39] ?? '',
                        'ayah_kandung' => $row[40] ?? '',
                        'ibu_kandung' => $row[41] ?? '',
                        'ayah_mertua' => $row[42] ?? '',
                        'ibu_mertua' => $row[43] ?? '',
                        'jumlah_tanggungan' => $row[44] ?? '',
                        'status_pajak' => $row[45] ?? '',
                        'npwp' => $row[46] ?? '',
                        'agama' => $row[47] ?? '',
                        'pendidikan_diakui' => $row[48] ?? '',
                        'jurusan' => $row[49] ?? '',
                        'almamater' => $row[50] ?? '',
                        'tahun_lulus' => $row[51] ?? '',
                        'pendidikan_terakhir' => $row[52] ?? '',
                        'jurusan_terakhir' => $row[53] ?? '',
                        'almamater_terakhir' => $row[54] ?? '',
                        'tahun_lulus_terakhir' => $row[55] ?? '',
                        'mpp' => $row[56] ?? '',
                        'pensiun' => $row[57] ?? '',
                        'ukuran_baju' => $row[58] ?? '',
                        'ukuran_celana' => $row[59] ?? '',
                        'ukuran_sepatu' => $row[60] ?? '',
                        'vaksin_1' => $row[61] ?? '',
                        'vaksin_2' => $row[62] ?? '',
                        'vaksin_3' => $row[63] ?? '',

                    ]);
                
                }
            }
        }
    }
}
