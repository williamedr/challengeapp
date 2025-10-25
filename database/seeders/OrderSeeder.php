<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OrderSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$this->truncate();

		Order::factory()->count(20)->create();

	}


	private function truncate() {
		Schema::disableForeignKeyConstraints();

		DB::table('cache_locks')->truncate();
		DB::table('jobs')->truncate();
		DB::table('notifications')->truncate();
		DB::table('orders')->truncate();
		DB::table('order_items')->truncate();
		DB::table('invoices')->truncate();

		Schema::enableForeignKeyConstraints();
	}

}
