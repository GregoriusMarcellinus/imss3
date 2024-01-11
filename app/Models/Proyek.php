<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;
    protected $table = 'proyek';
    protected $fillable = [
        'kode_tempat',
        'nama_tempat',
        'lokasi',
        'nama_proyek',
        'proyek_mulai',
        'proyek_selesai',
        'proyek_status',
        'trainset_kode',
        'trainset_nama',
        'file',
    ];
    
    // Format tanggal
    protected $dates = ['proyek_mulai', 'proyek_selesai'];

    // Format tanggal yang dapat diubah
    protected $casts = [
        'proyek_mulai' => 'datetime:Y-m-d',
        'proyek_selesai' => 'datetime:Y-m-d',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($proyek) {
            // Periksa apakah tanggal selesai proyek sudah lewat
            if (Carbon::now()->gt($proyek->proyek_selesai)) {
                // Jika iya, set status proyek menjadi "close"
                $proyek->proyek_status = 'close';
            }
        });
    }
}
