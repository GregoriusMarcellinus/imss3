<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Justifikasi extends Model
{
    use HasFactory;

    protected $table = 'justifikasi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'nomor',
        'keterangan',
        'file',
    ];
}
