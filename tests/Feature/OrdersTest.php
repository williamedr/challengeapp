<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use AuthenticatedApiTest;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;


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

		$this->checkOrderStructure($response);

	}


	public function test_get_all_orders_created_by_user(): void
	{

		$this->actingAs($this->user);


		$response = $this->getJson('/api/orders');
		$response->assertStatus(200);

		$this->checkOrderStructure($response);

	}




	public function test_get_one_order_created_by_user(): void
	{

		$user = $this->user;

		$order = $user->orders()->inRandomOrder()->first();
		$order_id = $order->id;

		$this->actingAs($user);


		$response = $this->getJson("/api/orders/$order_id");
		$response->assertStatus(200);

		$this->checkOrderStructure($response);

	}



	public function test_get_one_order_not_created_by_user(): void
	{

		$user = $this->differentUser;

		$order = $user->orders()->inRandomOrder()->first();
		$order_id = $order->id;

		$this->actingAs($user);

		$response = $this->getJson("/api/orders/$order_id");
		$response->expectException(AccessDeniedException::class);

	}



	private function checkOrderStructure($response) {

		$data = $response->decodeResponseJson();

		if (is_array($data)) {
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

		} else if (is_object($data)) {
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
		}

	}


}
