<?php

namespace App\Observers;

use App\Models\OrderItem;
use App\Models\Product;

class OrderItemObserver
{
	/**
	 * Handle the Order "created" event.
	 */
	public function created(OrderItem $item): void
	{
		$this->updateOrderTotal($item);
	}

	/**
	 * Handle the Order "updated" event.
	 */
	public function updated(OrderItem $item): void
	{
		$this->updateOrderTotal($item);
	}

	/**
	 * Handle the Order "creating" event.
	 */
	public function creating(OrderItem $item): void
	{
		$this->updateItemPrice($item);
	}

	/**
	 * Handle the Order "creating" event.
	 */
	public function updating(OrderItem $item): void
	{
		$this->updateItemPrice($item);
	}

	/**
	 * Handle the Order "deleted" event.
	 */
	public function deleted(OrderItem $item): void
	{
		$this->updateOrderTotal($item);
	}

	/**
	 * Handle the Order "restored" event.
	 */
	public function restored(OrderItem $item): void
	{
		$this->updateOrderTotal($item);
	}

	/**
	 * Handle the Order "force deleted" event.
	 */
	public function forceDeleted(OrderItem $item): void
	{
		$this->updateOrderTotal($item);
	}


	private function updateOrderTotal(OrderItem $item) {
		$order = $item->order;

		$order->total = $order->order_items()->sum('subtotal');

		$order->save();
	}


	private function updateItemPrice(OrderItem $item) {
		$product = Product::findOrFail($item->product_id);

		if (!empty($product)) {
			$item->unit_price = $product->price;
			$item->subtotal = $item->quantity * $product->price;
		}
	}

}
