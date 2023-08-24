<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = [
            'product_code'          => $row['KODE PRODUK'],
            'product_name'          => $row['NAMA PRODUK'],
            'purchase_price'        => $row['HARGA PEMBELIAN'],
            'sale_price'            => $row['HARGA SATUAN'],
        ];

        return new Product($product);
    }
}
