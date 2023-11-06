<?php

namespace App\Imports;

use App\Models\ProductWIP;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsWIPImport implements ToModel, WithHeadingRow
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
            'customer'              => $row['CUSTOMER'],
            'no_nota'               => $row['NO NOTA'],
            'amount'                => $row['JUMLAH'],
        ];

        return new ProductWIP($product);
    }
}
