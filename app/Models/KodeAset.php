<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeAset extends Model
{
    use HasFactory;

    protected $table = 'kode_aset';
    protected $fillable = [
        'kode',
        'keterangan',
    ];

}
