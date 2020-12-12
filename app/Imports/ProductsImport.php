<?php

namespace App\Imports;

use App\Entities\Product;
use App\Entities\ErrorImport;
use Illuminate\Bus\Queueable;
use Illuminate\Validation\Rule;
use App\Constants\ProductStatus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithUpserts;
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
    WithChunkReading,
    WithBatchInserts,
    SkipsOnFailure,
    ShouldQueue
{
    use Importable;
    use SkipsFailures;

    /**
     * @var int
     */
    private int $rows = 0;

    /**
     * @param array $row
     */
    public function model(array $row)
    {
        ++$this->rows;

        Product::updateOrCreate(
            [
                'name' => $row['name'],
                'slug' => $row['name'],

            ],
            [
                'actual_price' => $row['actual_price'],
                'category_id' => $row['category_id'],
                'details' => $row['details'],
                'description' => $row['description'],
                'status' => $row['status'],
                'stock' => $row['stock']
            ]
        );
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
            'stock' => 'numeric|min:0|not_in:0',
            'category_id' => 'required|exists:categories,id',
            'status' => Rule::in(ProductStatus::ARRAY)
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
    public function chunkSize(): int
    {
        return 10000;
    }

    /**
     * @return int
     */
    public function batchSize(): int
    {
        return 10000;
    }

    /**
     * @param Failure ...$failures
     * @return void
     */
    public function onFailure(Failure ...$failures): void
    {
        foreach ($failures as $failure) {
            ErrorImport::create([
                'import' => trans('products.messages.import.start'),
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'values' => implode(', ', $failure->values()),
                'errors' => implode(', ', $failure->errors()),
            ]);
        }
    }
}
