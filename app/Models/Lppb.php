<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lppb extends Model
{
    use HasFactory;

    protected $table = 'lppb';

    protected $fillable = [
        'id_registrasi_barang',
        'penerimaan',
        'hasil_ok',
        'hasil_nok',
        'keterangan',
    ];
}
