<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrawingSchematic extends Model
{
    use HasFactory;

    protected $table = 'drawing_schematic';

    protected $fillable = [
        'user_id',
        'tanggal',
        'nomor',
        'keterangan',
        'file',
    ];
}
