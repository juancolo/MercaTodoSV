<?php

namespace App\Exports;

use App\Entities\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductsExport implements FromCollection, Responsable, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public $fileName = 'products.xlsx';
    private $writerType = Excel::XLSX;
    private $headers =[
        'Content-Type'=> 'test/csv'
    ];

    public function headings(): array
    {
        return [
            'id',
            'name',
            'actual_price',
            'category_id'
        ];
    }

    /**
    * @return Collection
    */
    public function collection()
    {
        return Product::all();
    }
}
