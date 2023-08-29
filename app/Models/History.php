<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    public function definition(): array{
    return[
        'no',
        'tanggal',
        'name',
        'shelf_name',
        'product_code',
        'product_name',
        'no_sjn',
        'vendor',
        'in',
        'out',
        'retur',
        'ending_amount',
        'satuan'
    ];
}
}
 