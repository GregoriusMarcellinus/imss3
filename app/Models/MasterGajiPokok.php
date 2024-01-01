<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterGajiPokok extends Model
{
    use HasFactory;
    protected $table = 'master_gaji_pokok';

    protected $fillable = [
        'tipe',
        'golongan',
        'besaran_nilai',
    ];
}
