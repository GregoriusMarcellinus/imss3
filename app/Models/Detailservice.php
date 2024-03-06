<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailservice extends Model
{
    use HasFactory;
    protected $table = 'detailservice';
    protected $fillable = [
        'id_service',
        'kode_material',
        'nama_barang',
        'spesifikasi',
        
    ];
}
