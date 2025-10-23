<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class OrderFactory extends Factory
{
	protected $model = Order::class;

	public function definition()
	{
		return [
			// 'tenant_id',
			'user_id' => User::inRandomOrder()->first()->id,
			'status' => $this->faker->randomElement(array_column(OrderStatus::cases(), 'value')),
			'total' => $this->faker->randomFloat(2, 1, 1000),
		];
	}


	public function configure()
	{
		return $this->afterCreating(function (Order $order) {
			$range = $this->faker->numberBetween(1, 4);

			OrderItem::factory()->count($range)->for($order)->create();

			$order->update([
				'total' => $order->orderItems->sum('subtotal')
			]);
		});
	}

}
