<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use AuthenticatedApiTest;


class OrdersTest extends AuthenticatedApiTest
{

	public function test_get_all_orders_by_admin(): void
	{

		$this->actingAs($this->adminUser);

		$response = $this->getJson('/api/orders');
		$response->assertStatus(200);

		$this->checkOrderStructure($response);

	}


	public function test_get_any_order_by_admin(): void
	{

		$this->actingAs($this->adminUser);

		$order = Order::inRandomOrder()->first();

		$response = $this->getJson("/api/orders/{$order->id}");
		$response->assertStatus(200);

		$this->checkOrderStructure($response, 1);
	}


	public function test_get_all_orders_created_by_user(): void
	{

		$this->actingAs($this->user);


		$response = $this->getJson('/api/orders');
		$response->assertStatus(200);

		$this->checkOrderStructure($response);

	}


	public function test_get_all_orders_user_empty_orders(): void
	{

		$this->actingAs($this->userNoOrders);


		$response = $this->getJson('/api/orders');
		$response->assertStatus(200);

		$this->checkOrderStructure($response, 2);

	}


	public function test_get_one_orders_user_empty_orders(): void
	{
		$user = $this->userNoOrders;

		$this->actingAs($user);

		$differentUser = User::whereHas('clients')
			->inRandomOrder()
			->whereHas('orders')
			->where('id', '<>', $user->id)
			->first();

		$order = $differentUser->orders()->inRandomOrder()->first();
		$order_id = $order->id;

		$response = $this->getJson("/api/orders/$order_id");
		$response->assertStatus(404);

	}


	public function test_get_one_order_created_by_user(): void
	{

		$user = $this->user;

		$order = $user->orders()->inRandomOrder()->first();
		$order_id = $order->id;

		$this->actingAs($user);


		$response = $this->getJson("/api/orders/$order_id");
		$response->assertStatus(200);

		$this->checkOrderStructure($response, 1);

	}



	public function test_get_one_order_not_created_by_user(): void
	{

		$user = $this->user;

		$this->actingAs($user);

		$order = $this->differentUser->orders()->inRandomOrder()->first();
		$order_id = $order->id;

		echo "Order Id: " . $order_id . PHP_EOL;
        echo "User Id: " . $user->id . PHP_EOL;
        echo "Different User Id: " . $this->differentUser->id . PHP_EOL;

		$response = $this->getJson("/api/orders/$order_id");
		$response->assertStatus(404);

	}



	private function checkOrderStructure($response, $opt = 0) {

		if ($opt == 0) {
			$response->assertJsonStructure([
				"success",
				'data' => [
					'*' => [
						"id",
						"client_id",
						"user_id",
						"status",
						"total",
						"created_at",
						"updated_at",
						"order_items"
					]
				]
			]);

		} else if ($opt == 1) {
			$response->assertJsonStructure([
				"success",
				'data' => [
					"id",
					"client_id",
					"user_id",
					"status",
					"total",
					"created_at",
					"updated_at",
					"order_items"
				]
			]);

		} else if ($opt == 2) {
			$response->assertJsonStructure([
				"success",
				'data' => []
			]);
		}

	}


}
