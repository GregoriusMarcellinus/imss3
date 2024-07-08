<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailNego extends Model
{
    use HasFactory;
    protected $table = 'detail_nego';
    protected $fillable = [
        'nego_id',
        'id_detail_pr',
        'harga',
    ];
}
