<?php

namespace App\Exports;

use App\Entities\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements
    FromQuery,
    WithHeadings,
    ShouldAutoSize,
    WithMapping
{
    use Exportable;

    private $headers =[
        'Content-Type'=> 'csv'
    ];

    public function headings(): array
    {
        return [
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

    public function map($product): array
    {
        return [
            $product->name,
            $product->slug,
            $product->details,
            $product->description,
            $product->actual_price,
            $product->category->name,
            $product->status,
            $product->stock
        ];
    }

}
