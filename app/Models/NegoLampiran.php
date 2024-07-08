<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NegoLampiran extends Model
{
    use HasFactory;

    protected $table = 'nego_lampiran';

    protected $fillable = [
        'nego_id',
        'file',
        'tipe',
    ];
}
