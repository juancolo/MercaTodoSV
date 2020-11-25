<?php

namespace App\Imports;

use App\Entities\Product;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnFailure,
    ShouldQueue,
    WithChunkReading,
    WithBatchInserts
{
    use Importable;
    use SkipsFailures;

    /**
     * @var int
     */
    private int $rows = 0;

    /**
     * @param array $row
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        ++$this->rows;

        return Product::updateOrCreate(
            [
                'name' => $row['name'],
                'slug' => $row['slug'],
            ],

            [
                'actual_price' => $row['actual_price'],
                'category_id' => $row['category_id'],
                'details' => $row['details'],
                'description' => $row['description'],
                'status' => $row['status'],
                'stock' => $row['stock']
            ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3', 'max:70',
                'regex:/^[^\{\}\[\]\;\<\>]*$/'],

            'slug' => [
                'required',
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

    /**
     * @return int
     */
    public function getRowCount(): int
    {
        return $this->rows;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 1000;
    }
}
