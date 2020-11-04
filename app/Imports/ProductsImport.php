<?php

namespace App\Imports;

use App\Entities\Product;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;

class ProductsImport implements OnEachRow
{
    use Importable;

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        Product::updateOrCreate(
            ['name'=>$row[1],
             'slug'=>$row[2]],
            [
            'name' => $row[1],
            'slug' => $row[2],
            'details' => $row[3],
            'actual_price' => $row[5],
            'category_id' => $row[7],
        ]);
    }

}
