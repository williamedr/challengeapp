<?php
namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;


class ProductRepository implements ProductInterface
{
	public $product;

	public function __construct(Product $product)
	{
		$this->product = $product;
	}


	public function all($filters = [])
	{
		$query = $this->product;

		if (!empty($filters)) {
			$query->where($filters);
		}

		$result = $query->get();

		return $result;
	}

	public function get(int $id)
	{
		return $this->product->findOrFail($id);
	}

	public function create(Product $product)
	{
		$product->save();

		return $product;
	}

	public function update(Product $product)
	{
		$product->save();

		return $product;
	}

	public function delete(Product $product)
	{
		$product->delete();

		return $product;
	}

}
