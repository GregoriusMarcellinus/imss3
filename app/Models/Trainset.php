<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainset extends Model
{
    use HasFactory;
    protected $table = 'trainset';
    protected $fillable = [
        'nama_tempat',
        'nama_proyek',
        'proyek',
        'trainset_kode',
        'trainset_nama',
        'car_nomor',
        'car_nama',
        
    ];
}
