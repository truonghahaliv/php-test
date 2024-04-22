<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductInterface
{
    protected Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function paginate($perPage = 5)
    {
        return $this->product->paginate($perPage);
    }
    public function create(array $data)
    {
        return $this->product->create($data);
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        return $product->delete();
    }
}
