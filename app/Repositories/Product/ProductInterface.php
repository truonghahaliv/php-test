<?php

namespace App\Repositories\Product;

use App\Models\Product;

interface ProductInterface
{
    public function paginate($perPage = 5);

    public function create(array $data);
    public function update(Product $product, array $data);
    public function delete(Product $product);
}
