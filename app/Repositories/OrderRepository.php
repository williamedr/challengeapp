<?php
namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Invoice;
use App\Models\Order;
use App\Notifications\OrderCreated;
use Illuminate\Support\Facades\Auth;

class OrderRepository implements OrderInterface
{
	public $order;

	public function __construct(Order $order)
	{
		$this->order = $order;
	}


	public function all($filters = [])
	{
		$query = $this->order;

		if (!empty($filters)) {
			$query->where($filters);
		}

		$result = $query->get();

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

}
