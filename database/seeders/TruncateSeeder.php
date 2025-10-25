<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TruncateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        self::truncateAll();
    }


	public static function truncateAll() {
		Schema::disableForeignKeyConstraints();

		DB::table('cache_locks')->truncate();
		DB::table('jobs')->truncate();
		DB::table('notifications')->truncate();

        DB::table('client_user')->truncate();
		DB::table('clients')->truncate();
		DB::table('roles')->truncate();
		DB::table('users')->truncate();
		DB::table('products')->truncate();

        self::truncateOrders();

		Schema::enableForeignKeyConstraints();
	}


	public static function truncateOrders() {
		Schema::disableForeignKeyConstraints();

		DB::table('orders')->truncate();
		DB::table('order_items')->truncate();
		DB::table('invoices')->truncate();

		Schema::enableForeignKeyConstraints();
	}

}
