<?php

namespace App\Exports;

use App\Entities\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements
    FromQuery,
    WithHeadings,
    ShouldAutoSize,
    ShouldQueue
{
    use Exportable;

    private $headers =[
        'Content-Type'=> 'csv'
    ];

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Slug',
            'Details',
            'Description',
            'Actual Price',
            'Category id',
            'Status',
            'Stock'
        ];
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return Product::query()
            ->select(
                'id',
                'name',
                'slug',
                'details',
                'description',
                'actual_price',
                'category_id',
                'status',
                'stock'
            );
    }

}
