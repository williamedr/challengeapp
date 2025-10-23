<?php
namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Order;

class OrderRepository implements OrderInterface
{
	public $order;

	public function __construct(Order $order)
	{
		$this->order = $order;
	}


	public function all($filters = [])
	{
		if (empty($filters)) {
			$query = $this->order;
		} else {
			$query = $this->order->where($filters);
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
		return $this->order->findOrFail($id);
	}


	public function create(Order $order)
	{
		$order->save();

		return $order;
	}


	public function update(Order $order)
	{
		$order->save();

		return $order;
	}


	public function delete(Order $order)
	{
		$order->delete();

		return $order;
	}


	public function createInvoice(Order $order)
	{

	}

}
