<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductWIP extends Model
{
    use HasFactory;
    protected $table = "products_wip";
    public $timestamps = false; 
    protected $fillable = ['customer', 'no_nota', 'product_amount'];
}
