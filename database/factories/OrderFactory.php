<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OrderStatus;
use App\Models\ClientUser;
use App\Models\Order;
use App\Models\OrderItem;


class OrderFactory extends Factory
{
	protected $model = Order::class;

	public function definition()
	{
		$clientUser = ClientUser::inRandomOrder()->first();

		return [
			'client_id' => $clientUser->client_id,
			'user_id' => $clientUser->user_id,
			'status' => $this->faker->randomElement(array_column(OrderStatus::cases(), 'value')),
			'total' => $this->faker->randomFloat(2, 1, 1000),
		];
	}


	public function configure()
	{
		return $this->afterCreating(function (Order $order) {
			$range = $this->faker->numberBetween(1, 4);

			OrderItem::factory()->count($range)->for($order)->create();

			// Checking and removing duplicated products in order
			$res = OrderItem::selectRaw('order_id, product_id, COUNT(*) c')->where(['order_id' => $order->id])->groupBy(['order_id', 'product_id'])->having('c', '>', 1)->first();

			if (!empty($res)) {
				$product_id = $res['product_id'];

				$cond['product_id'] = $product_id;
				$cond['order_id'] = $order->id;
				$item = OrderItem::where($cond)->orderBy('id', 'ASC')->first();

				OrderItem::where($cond)->where('id', '>', $item->id)->delete();

				$order->refresh();
			}

			$order->update([
				'total' => $order->order_items->sum('subtotal')
			]);
		});
	}

}
