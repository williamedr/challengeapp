<?php

namespace App\Jobs;

use Exception;
use App\Models\Invoice;
use App\Models\Order;
use App\Notifications\InvoiceCreated;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GenerateInvoiceJob implements ShouldQueue, ShouldBeUnique
{
	use Queueable;


	protected $order;


	/**
	 * Create a new job instance.
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}


	/**
	 * Get the unique ID for the job.
	 */
	public function uniqueId(): string
	{
		return $this->order->id;
	}


	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		try {
			$order = $this->order;
			$order_id = $order->id;

			$invoice = Invoice::create([
				'client_id' => $order->client_id,
				'order_id' => $order_id,
				'invoice_number' => str_pad($order_id, 8, '0', STR_PAD_LEFT),
				'total' => $order->total,
				'issued_at' => now(),
			]);

			$order->user->notify(new InvoiceCreated($invoice));

			Cache::flush();

		} catch (Exception $e) {
			Log::error("Error processing job: " . $e->getMessage());
			throw $e;
		}

	}
}
