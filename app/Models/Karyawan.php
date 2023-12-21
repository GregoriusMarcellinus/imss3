<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawan';

    protected $fillable = [
        'nip', 'nama', 'tanggal_masuk', 'status_pegawai', 'rekrutmen', 'domisili',
        'rekening_mandiri', 'rekening_bsi', 'sk_pengangkatan_atau_kontrak',
        'tanggal_pengangkatan_atau_akhir_kontrak', 'jabatan_inka', 'jabatan_imss',
        'administrasi_atau_teknisi', 'lokasi_kerja', 'bagian_atau_proyek',
        'departemen_atau_subproyek', 'divisi', 'direktorat', 'sertifikat',
        'surat_peringatan', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'nomor_ktp', 'alamat', 'nomor_hp', 'email', 'bpjs_kesehatan',
        'bpjs_ketenagakerjaan', 'status_pernikahan', 'suami_atau_istri',
        'anak_ke_1', 'anak_ke_2', 'anak_ke_3', 'tambahan', 'ayah_kandung',
        'ibu_kandung', 'ayah_mertua', 'ibu_mertua', 'jumlah_tanggungan',
        'status_pajak', 'npwp', 'agama', 'pendidikan_diakui', 'jurusan',
        'almamater', 'tahun_lulus', 'pendidikan_terakhir', 'jurusan_terakhir',
        'almamater_terakhir', 'tahun_lulus_terakhir', 'mpp', 'pensiun',
        'ukuran_baju', 'ukuran_celana', 'ukuran_sepatu', 'vaksin_1', 'vaksin_2',
        'vaksin_3',
    ];
}
