<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Client;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		// Truncate tables
		$this->truncate();


		// Create Roles
		$this->call([RolesSeeder::class]);


		// Create 3 Clients
		Client::factory()->count(3)->create();

		// Create 10 Products
		Product::factory()->count(10)->create();


		// Create 1 Admin users
		User::factory()->admin()->create();

		// Create 2 Manager users
		User::factory()->manager()->count(2)->create();

		// Create 3 users
		User::factory()->count(3)->create();


		// Create Orders
		$this->call([OrderSeeder::class]);


	}


	private function truncate() {
		$this->call([TruncateSeeder::class]);
	}

}
