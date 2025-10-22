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

		return [
			// 'tenant_id',
			'order_id' => Order::inRandomOrder()->first()->id,
			'product_id' => Product::inRandomOrder()->first()->id,
			'quantity' => $quantity,
			'unit_price' => $unit_price,
			'subtotal' => $subtotal,
		];
	}

}
