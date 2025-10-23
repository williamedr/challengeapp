<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Invoice;
use App\Models\Order;

class InvoiceFactory extends Factory
{
	protected $model = Invoice::class;

	public function definition()
	{
		$order = Order::inRandomOrder()->first();
		$order_id = $order->id;

		return [
			'order_id' => $order_id,
			'invoice_number' => str_pad($order_id, 8, '0', STR_PAD_LEFT),
			'total' => $order->total,
			'issued_at' => $this->faker->dateTimeInInterval('-15 days', '+ 5 days', "UTC"),
		];
	}


}
