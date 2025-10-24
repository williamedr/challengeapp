<?php
namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

		if (empty($filters)) {
			$query = $this->product;
		} else {
			$query = $this->product->where($filters);
		}

		if (isset($filters['id'])) {
			$result = $query->first();

			if (empty($result)) {
				$result = [];
			}

		} else {
			$result = $query->get();
		}

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
