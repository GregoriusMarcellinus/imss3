<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nego extends Model
{
    use HasFactory;
    protected $table = 'nego';
    protected $fillable = [
        'nomor_nego',
        'id_pr',
        'nomor_pr',
        'lampiran',
        'vendor_id',
        'tanggal_nego',
        'batas_nego',
        'perihal',
        'penerima',
        'alamat'
    ];
}
