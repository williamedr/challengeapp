<?php
namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Interfaces\OrderItemInterface;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

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


	public function create(Order $order, $items = [])
	{
		$order->save();

		if (!empty($items)) {
			foreach ($items as $item) {
				$it = new OrderItem();
				$it->order_id = $order->id;
				$it->quantity = $item['quantity'];
				$it->product_id = $item['product_id'];
				$it->save();
			}

			$order->refresh();
			$order->order_items;
		}

		return $order;
	}


	public function update(Order $order, $items = [])
	{
		$order->save();

		if (!empty($items)) {
			foreach ($items as $item) {

				if (isset($item['id'])) {
					$it = OrderItem::findOrFail($item['id']);
				} else {
					$it = new OrderItem();
				}

				$it->order_id = $order->id;
				$it->quantity = $item['quantity'];
				$it->product_id = $item['product_id'];
				$it->save();
			}

			$order->refresh();
			$order->order_items;
		}

		return $order;
	}


	public function delete(Order $order)
	{
		$order->delete();

		return $order;
	}

}
