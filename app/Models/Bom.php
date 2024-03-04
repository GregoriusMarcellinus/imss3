<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    use HasFactory;
    protected $table = 'bom';
    protected $fillable = [
        'id_service',
        'proyek_id',
        // 'nomor',
        'proyek',
        'tanggal',
        'kode_material',
        'deskripsi_material',
        'spesifikasi',
        'jenis_perawatan',
        'trainset',
        'car',
        'corrective_part',
        'jumlah',
        'satuan',
        'keterangan',
    ];
    
    // Format tanggal
    // protected $dates = ['proyek_mulai', 'proyek_selesai'];

    // Format tanggal yang dapat diubah
    protected $casts = [
        'tanggal' => 'datetime:Y-m-d',
        // 'proyek_selesai' => 'datetime:Y-m-d',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($proyek) {
    //         // Periksa apakah tanggal selesai proyek sudah lewat
    //         if (Carbon::now()->gt($proyek->proyek_selesai)) {
    //             // Jika iya, set status proyek menjadi "close"
    //             $proyek->proyek_status = 'close';
    //         }
    //     });
    // }
}
