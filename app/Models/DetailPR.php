<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPR extends Model
{
    use HasFactory;
    protected $table = 'detail_pr';
    protected $fillable = [
        'id_pr',
        'kode_material',
        'uraian',
        'spek',
        'qty',
        'satuan',
        'waktu',
        'keterangan'
    ];
}
