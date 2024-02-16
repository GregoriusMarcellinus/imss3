<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'service';
    protected $fillable = [
        'nama_tempat',
        'lokasi',
        'nama_proyek',
        'trainset',
        'car',
        'perawatan',
        'perawatan_mulai',
        'perawatan_selesai',
        'komponen_diganti',
        'tanggal_komponen',
        'pic',
        'keterangan',
    ];
    
    // Format tanggal
    protected $dates = ['perawatan_mulai', 'perawatan_selesai'];

    // Format tanggal yang dapat diubah
    protected $casts = [
        'perawatan_mulai' => 'datetime:Y-m-d',
        'perawatan_selesai' => 'datetime:Y-m-d',
    ];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($service) {
    //         // Periksa apakah tanggal selesai proyek sudah lewat
    //         if (Carbon::now()->gt($service->perawatan_selesai)) {
    //             // Jika iya, set status proyek menjadi "close"
    //             $service->proyek_status = 'close';
    //         }
    //     });
    // }
}
