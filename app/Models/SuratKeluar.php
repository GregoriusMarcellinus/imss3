<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    public $timestamps = false;

    protected $fillable = [
        'direksi',
        'type',
        'no_surat',
        'tujuan',
        'uraian',
        'id_user',
        'file',
        'status',
        'created_at'
    ];
}
