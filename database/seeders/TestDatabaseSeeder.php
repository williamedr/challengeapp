<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TestDatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{

		Schema::disableForeignKeyConstraints();

		DB::table('cache_locks')->truncate();
		DB::table('jobs')->truncate();
		DB::table('client_user')->truncate();
		DB::table('clients')->truncate();
		DB::table('users')->truncate();
		DB::table('products')->truncate();

		DB::table('notifications')->truncate();
		DB::table('orders')->truncate();
		DB::table('order_items')->truncate();
		DB::table('invoices')->truncate();

		Schema::enableForeignKeyConstraints();


		Client::factory()->count(3)->create();


		User::factory()->count(3)->create([
			'name' => 'admin'
		]);

		User::factory()->count(3)->create();


		Product::factory()->count(10)->create();


		$this->call([OrderSeeder::class]);

	}
}
