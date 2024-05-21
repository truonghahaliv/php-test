<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportProduct implements FromCollection, WithHeadings, WithMapping
{


    protected Collection $product;
    public function __construct(Collection $product)
    {
        $this->product = $product;
    }

    public function collection() :Collection
    {
        // TODO: Implement collection() method.
        return $this->product;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Price',
            'Quantity',
            'Description',

        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->price,
            $product->quantity,
            $product->description,

        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'name',
            'price',
            'quantity',
            'description',

        ];
    }



}
