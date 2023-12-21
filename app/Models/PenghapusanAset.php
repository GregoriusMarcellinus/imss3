<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenghapusanAset extends Model
{
    use HasFactory;
    protected $table = 'penghapusan_aset';
    protected $fillable = [
        'kode_aset_id',
        'tipe',
        'nomor_aset',
        'jenis_aset',
        'merek',
        'no_seri',
        'kondisi',
        'tanggal_perolehan',
        'lokasi',
        'pengguna',
        'keterangan',
    ];
}
