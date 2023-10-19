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
        'id_spph',
        'id_po',
        'kode_material',
        'uraian',
        'spek',
        'qty',
        'satuan',
        'waktu',
        'keterangan',
        'status',
        'no_sph',
        'tanggal_sph',
        'no_just',
        'tanggal_just',
        'no_nego1',
        'tanggal_nego1',
        'batas_nego1',
        'no_nego2',
        'tanggal_nego2',
        'batas_nego2',
    ];
}
