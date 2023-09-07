<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSpph extends Model
{
    use HasFactory;
    protected $table = 'detail_spph';
    protected $fillable = [
        'spph_id',
        'id_detail_pr',
    ];
}
