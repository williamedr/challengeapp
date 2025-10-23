<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Order;
use App\Notifications\InvoiceCreated;


class OrderObserver
{
	/**
	 * Handle the Order "created" event.
	 */
	public function created(Order $order): void
	{
		$order_id = $order->id;

		Invoice::create([
			'order_id' => $order_id,
			'invoice_number' => str_pad($order_id, 8, '0', STR_PAD_LEFT),
			'total' => $order->total,
			'issued_at' => now(),
		]);

		$order->refresh();

		$order->user->notify(new InvoiceCreated($order));
	}

	/**
	 * Handle the Order "updated" event.
	 */
	public function updated(Order $order): void
	{
		//
	}

	/**
	 * Handle the Order "deleted" event.
	 */
	public function deleted(Order $order): void
	{
		//
	}

	/**
	 * Handle the Order "restored" event.
	 */
	public function restored(Order $order): void
	{
		//
	}

	/**
	 * Handle the Order "force deleted" event.
	 */
	public function forceDeleted(Order $order): void
	{
		//
	}
}
