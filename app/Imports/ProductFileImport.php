<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductFileImport implements ToCollection, ToModel
{
    private $current = 0;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        return view('admin.products.index');
    }

    public function model(array $row)
    {
        $this->current++;
        if ($this->current > 1) {


            $product = new Product();
            $product->name = $row[0];
            $product->price = $row[1];
            $product->quantity = $row[2];
            $product->description = $row[3];
            $product->image = $row[4];
            $product->save();


        }
    }

}
