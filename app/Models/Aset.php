<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'asets';
    protected $fillable = [
        'aset_id',
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
