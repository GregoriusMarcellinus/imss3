<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiBarang extends Model
{
    
    use HasFactory;

    protected $table = 'registrasi_barang';

    protected $fillable = [
        'id_barang',
        'id_user',
        'keterangan',
    ];
}
