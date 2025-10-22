<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
		DB::table('invoices')->truncate();

		Schema::enableForeignKeyConstraints();


        User::create([
            'name' => 'William',
            'email' => 'williamedr@gmail.com',
			'email_verified_at' => now(),
            'password' => Hash::make('123456'),
			'remember_token' => Str::random(10),
        ]);


		User::factory()->count(3)->create();


		Product::factory()->count(20)->create();


		Order::factory()->count(12)->create();


		Invoice::factory()->count(3)->create();

	}
}
