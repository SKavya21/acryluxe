<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAll()
    {
        return Product::latest()->get();
    }

    public function create($data)
    {
        return Product::create($data);
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function update($id, $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        return $product->delete();
    }
}