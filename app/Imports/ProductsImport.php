<?php

namespace App\Imports;

use App\Entities\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements
    OnEachRow,
    WithHeadingRow,
    WithValidation,
    WithBatchInserts,
    WithChunkReading,
    ShouldQueue
{
    use Importable;

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        Product::updateOrCreate(
            [
                'name' => $row['name'],
            ],

            [
                'name' => $row['name'],
                'actual_price' => $row['actual_price'],
                'category_id' => $row['category_id'],
                'slug' => $row['slug'],
                'details' => $row['details'],
                'description' => $row['description'],
                'status' => $row['status'],
                'stock' => $row['stock']
            ]);
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'unique:products',
                'min:3', 'max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'slug' => [
                'required',
                'unique:products',
                'min:3', 'max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'details' => 'min:3|max:80',
            'description' => 'min:3|max:200',
            'actual_price' => 'required|numeric|min:0|not_in:0',
            'old_price' => 'numeric|min:0|not_in:0',
            'category_id' => 'required|exists:categories,id',
            'status' => Rule::in(['ACTIVO', 'INACTIVO'])
        ];
    }
    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
      return 1000;
    }

}
