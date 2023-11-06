<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keproyekan extends Model
{
    use HasFactory;

    protected $table = 'keproyekan';
    protected $fillable = ['nama_proyek', 'warehouse_id'];
}
