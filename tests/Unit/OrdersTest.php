<?php

namespace Tests\Feature;

use AuthenticatedApiTest;

use App\Jobs\GenerateInvoiceJob;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Queue;


class OrdersTest extends AuthenticatedApiTest
{

	public function test_get_all_orders_not_authenticated_user(): void
	{
		$response = $this->getJson('/api/orders');
		$response->assertStatus(401);
	}


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

		$response = $this->getJson("/api/orders/$order_id");
		$response->assertStatus(404);

	}



	public function test_authenticated_orders_by_client(): void
	{

		$this->actingAs($this->user);

		$client = Client::inRandomOrder()->first();

		$client_id = $client->id;

		$response = $this->getJson("/api/clients/$client_id/orders");
		$response->assertStatus(200);

		$this->checkOrderStructure($response, 0);

	}


	public function test_authenticated_orders_by_bad_client(): void
	{

		$this->actingAs($this->user);

		$client_id = 666777888;

		$response = $this->getJson("/api/clients/$client_id/orders");
		$response->assertStatus(404);

	}


	public function test_authenticated_user_can_create_an_order(): void
	{
		Queue::fake();

		$user = $this->user;
		$this->actingAs($user);

		$orderData = Order::factory()->create()->toArray();

		$response = $this->post(route('orders.store'), $orderData);

		$response->assertStatus(201);

		$this->assertDatabaseHas('orders', [
			'user_id' => $user->id,
			'id' => $orderData['id'],
		]);

		Queue::assertPushed(GenerateInvoiceJob::class); // Assert that GenerateInvoiceJob was pushed

		$this->test_get_all_invoices();

	}



	public function test_authenticated_user_can_update_an_order(): void
	{
		$user = $this->user;

		$this->actingAs($user);

		$order = $user->orders()->inRandomOrder()->first();

		$items = [];

		foreach ($order->order_items as $row) {
			$items[] = [
				'product_id' => $row['product_id'],
				'quantity' => $row['quantity'] + 1,
			];
		}

		$updatedData = [
			'status' => 'pending',
			'order_items' => $items,
		];

		$response = $this->put(route('orders.update', $order), $updatedData);

		$response->assertStatus(200);

		$this->assertDatabaseHas('orders', [
			'id' => $order->id,
			'status' => 'pending',
		]);
	}



	public function test_get_all_invoices(): void
	{

		$this->actingAs($this->user);

		$response = $this->getJson('/api/invoices');
		$response->assertStatus(200);

		$this->checkInvoiceStructure($response);

		$this->assertGreaterThanOrEqual(1, count($response['data']));

		$this->test_get_all_notifications();

	}


	public function test_get_all_notifications(): void
	{

		$this->actingAs($this->user);

		$response = $this->getJson('/api/notifications');
		$response->assertStatus(200);

		$this->assertGreaterThanOrEqual(1, count($response['data']));

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



	private function checkInvoiceStructure($response, $opt = 0) {

		if ($opt == 0) {
			$response->assertJsonStructure([
				"success",
				'data' => [
					'*' => [
						"id",
						"client_id",
						"order_id",
						"invoice_number",
						"total",
						"issued_at",
						"created_at",
						"updated_at",
					]
				]
			]);

		} else if ($opt == 1) {
			$response->assertJsonStructure([
				"success",
				'data' => [
					"id",
					"client_id",
					"order_id",
					"invoice_number",
					"total",
					"issued_at",
					"created_at",
					"updated_at",
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
