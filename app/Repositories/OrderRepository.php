<?php
namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\OrderItem;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
				throw new AccessDeniedHttpException('Access Denied for this Order.');
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
				$cond = [];
				$cond['order_id'] = $order->id;
				$cond['product_id'] = $item['product_id'];

				$tmpItem = OrderItem::where($cond)->first();

				if (empty($tmpItem)) {
					$it = new OrderItem();
					$it->order_id = $order->id;
					$it->quantity = $item['quantity'];
					$it->product_id = $item['product_id'];
					$it->save();

				} else {
					$tmpItem->quantity = $tmpItem->quantity + $item['quantity'];
					$tmpItem->save();
				}
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
				$cond = [];
				$cond['order_id'] = $order->id;
				$cond['product_id'] = $item['product_id'];

				$tmpItem = OrderItem::where($cond)->first();

				if (!empty($tmpItem)) {
					$tmpItem->quantity = $tmpItem->quantity + $item['quantity'];
					$tmpItem->save();

					continue;
				}

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
