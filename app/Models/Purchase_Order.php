<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase_Order extends Model
{
    use HasFactory;
    protected $table = 'purchase_order';
    protected $fillable = [
        'vendor_id',
        'no_po',
        'tanggal_po',
        'incoterm',
        'pr_no',
        'ref_sph',
        'no_just',
        'no_nego',
        'batas_po',
        'ref_po',
        'term_pay',
        'garansi',
        'proyek_id',
    ];
}
