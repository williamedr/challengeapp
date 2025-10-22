<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{

		Schema::disableForeignKeyConstraints();

		DB::table('users')->truncate();
		DB::table('products')->truncate();
		DB::table('orders')->truncate();

		Schema::enableForeignKeyConstraints();


        User::create([
            'name' => 'William',
            'email' => 'williamedr@gmail.com',
            'password' => Hash::make('123456'),
        ]);

		User::factory()->count(3)->create();


		Product::factory()->count(20)->create();


		Order::factory()->count(12)->create();

	}
}
