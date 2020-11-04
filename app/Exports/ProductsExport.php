<?php

namespace App\Exports;

use App\Entities\Product;
use Illuminate\Http\Request;
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

    public $fileName;
    private $headers =[
        'Content-Type'=> 'csv'
    ];

    public function __construct(Request $request)
    {
        $this->fileName = 'products.'.$request->extension;
    }

    public function headings(): array
    {
        return [
            'Id',
            'Name',
            'Actual Price',
            'Category id'
        ];
    }

    /**
    * @return Collection
    */
    public function collection()
    {
        return Product::select('id', 'name', 'actual_price', 'category_id' )->get();
    }
}
