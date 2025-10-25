<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{

		$this->truncate();


		// Create Roles
		$this->call([RolesSeeder::class]);


		// Create 3 Clients
		Client::factory()->count(3)->create();

		// Create 10 Products
		Product::factory()->count(10)->create();


		// Create 3 users
        User::factory()->count(3)->create();


		// Create Orders
		$this->call([OrderSeeder::class]);



		// Create 1 Admin users
        User::factory()->admin()->create();

		// Create 2 Manager users
        User::factory()->manager()->count(2)->create();

	}


	private function truncate() {
		Schema::disableForeignKeyConstraints();

		DB::table('cache_locks')->truncate();
		DB::table('jobs')->truncate();
		DB::table('client_user')->truncate();
		DB::table('clients')->truncate();
		DB::table('roles')->truncate();
		DB::table('users')->truncate();
		DB::table('products')->truncate();

		DB::table('notifications')->truncate();
		DB::table('orders')->truncate();
		DB::table('order_items')->truncate();
		DB::table('invoices')->truncate();

		Schema::enableForeignKeyConstraints();
	}

}
