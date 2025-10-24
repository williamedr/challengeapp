<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;


class OrderItemFactory extends Factory
{
	protected $model = OrderItem::class;

	public function definition()
	{
		$quantity = $this->faker->numberBetween(0, 100);
		$unit_price = $this->faker->randomFloat(2, 1, 1000);
		$subtotal = $quantity * $unit_price;


		$order = Order::inRandomOrder()->first();

		$product_ids = $order->order_items->pluck('product_id')->toArray();

		$product = Product::whereNotIn('id', $product_ids)->inRandomOrder()->first();

		return [
			'order_id' => $order->id,
			'product_id' => $product->id,
			'quantity' => $quantity,
			'unit_price' => $unit_price,
			'subtotal' => $subtotal,
		];
	}

}
