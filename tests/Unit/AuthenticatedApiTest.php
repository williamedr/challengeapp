<?php
	use App\Models\User;
	use Illuminate\Foundation\Testing\RefreshDatabase;
	use Tests\TestCase;

	class AuthenticatedApiTest extends TestCase
	{
		use RefreshDatabase; // Use RefreshDatabase trait to reset the database for each test

		protected User $user;

		protected function setUp(): void
		{
			parent::setUp();
			$this->user = User::factory()->create(); // Create a user for testing
		}


		public function test_authenticated_user_can_access_protected_api_endpoint(): void
		{
			$this->actingAs($this->user, 'api'); // Simulate authentication for the 'api' guard

			$response = $this->getJson('/api/user'); // Make your API request

			$response->assertStatus(200); // Assert the expected status code
			// Further assertions based on the API response data
		}

}