<?php
	use App\Models\User;
	use Illuminate\Foundation\Testing\RefreshDatabase;
	use Tests\TestCase;

	class AuthenticatedApiTest extends TestCase
	{
		use RefreshDatabase; // Use RefreshDatabase trait to reset the database for each test

		protected User $user;
		protected User $adminUser;
		protected User $differentUser;
		protected User $userNoOrders;


		protected function setUp(): void
		{
			parent::setUp();


			$this->seed(); // Runs DatabaseSeeder


			$this->user = User::whereHas('clients')
				->whereHas('orders')
				->inRandomOrder()
				->first();

			$this->differentUser = User::whereHas('clients')
				->whereHas('orders')
				->where('id', '<>', $this->user->id)
				->first();


			$this->userNoOrders = User::whereDoesntHave('orders')
				->whereHas('clients')
				->inRandomOrder()
				->first();


			// User without client relation
			$this->adminUser = User::whereDoesntHave('clients')
				->inRandomOrder()
				->first();
		}



		/**
		 * A basic feature test health.
		 */
		public function test_health(): void
		{
			$response = $this->get('/api/health');

			$response->assertStatus(200);
		}




		public function test_authenticated_user_endpoint(): void
		{
			$this->actingAs($this->user);

			$response = $this->getJson('/api/user');
			$response->assertStatus(200);

			$response->assertJsonStructure([
				"id",
				"name",
				"email",
				"email_verified_at",
				"created_at",
				"updated_at",
				'clients' => [
					'*' => [
						"id",
						"name",
						"email",
						"domain",
						"created_at",
						"updated_at",
						"pivot"
					]
				]
			]);

		}

	}