<?php

namespace App\Interfaces;

use App\Models\Order;

interface OrderInterface
{

	public function all(array $filters);

	public function get(int $id);

	public function create(Order $order);

	public function update(Order $order);

	public function delete(Order $order);

	public function createInvoice(Order $order);

}
