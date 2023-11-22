<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpphLampiran extends Model
{
    use HasFactory;

    protected $table = 'spph_lampiran';

    protected $fillable = [
        'spph_id',
        'file',
        'tipe',
    ];
}
