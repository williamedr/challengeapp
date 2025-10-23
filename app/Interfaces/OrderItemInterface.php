<?php

namespace App\Interfaces;

use App\Models\OrderItem;

interface OrderItemInterface
{

	public function all(array $filters);

	public function get(int $id);

	public function create(OrderItem $item);

	public function update(OrderItem $item);

	public function delete(OrderItem $item);

}
