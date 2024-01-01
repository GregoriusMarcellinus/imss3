<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiLembur extends Model
{
    use HasFactory;

    protected $table = 'gaji_lembur';

    protected $fillable = [
        'id_karyawan',
        'lembur_weekend',
        'lembur_weekday'
    ];
}
