<?php

namespace App\Interfaces;

use App\Models\Product;

interface ProductInterface
{

    public function all(array $filters);

	public function get(int $id);

	public function create(Product $product);

	public function update(Product $product);

	public function delete(Product $product);

}
