<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gangguan extends Model
{
    use HasFactory;
    protected $table = 'gangguan';
    protected $fillable = [
        'nama_tempat',
        'lokasi',
        'perkiraan_mulai',
        'perkiraan_selesai',
        'kondisi',
        'nama_proyek',
        'trainset',
        'car',
        'perawatan',
        'tanggal_gangguan',
        'perkiraan_gangguan',
        'penyebab_gangguan',
        'jenis_gangguan',
        'nama_barang',
        'jumlah',
        'satuan',
        'tindak_lanjut',
        'hasil_tindak_lanjut',
        'pelapor',
        'status',
        'keterangan',
        
    ];
}
