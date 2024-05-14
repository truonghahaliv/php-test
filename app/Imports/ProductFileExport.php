<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductFileExport implements WithHeadings, FromQuery, WithMapping {
    use Exportable;
    protected  $offset;
    protected $limit;
    public function __construct($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }


    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            '#',
            'Name',
            'Price',
            'Quantity',
            'Description',

        ];
    }

    public function map($product): array
    {
        // TODO: Implement map() method.
        return [
            $product->id,
            $product->name,
            $product->price,
            $product->quantity,
            $product->description,

        ];
    }

    public function query()
    {
        // TODO: Implement query() method.
        return Product::query()->offset($this->offset)->limit($this->limit);
    }
}
