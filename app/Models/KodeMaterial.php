<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeMaterial extends Model
{
    use HasFactory;
    protected $table = 'kode_material';
    protected $fillable = [
        'kode_material',
        'nama_material',
        'spesifikasi',
        'satuan',
    ];
}
