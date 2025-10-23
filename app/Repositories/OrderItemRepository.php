<?php
namespace App\Repositories;

use App\Interfaces\OrderItemInterface;
use App\Models\OrderItem;


class OrderItemRepository implements OrderItemInterface
{
	public $item;

	public function __construct(OrderItem $item)
	{
		$this->item = $item;
	}


	public function all($filters = [])
	{
		if (empty($filters)) {
			$query = $this->item;
		} else {
			$query = $this->item->where($filters);
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
		return $this->item->findOrFail($id);
	}


	public function create(OrderItem $item)
	{
		$item->save();

		return $item;
	}


	public function update(OrderItem $item)
	{
		$item->save();

		return $item;
	}


	public function delete(OrderItem $item)
	{
		$item->delete();

		return $item;
	}


}
