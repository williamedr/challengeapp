<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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

		Schema::enableForeignKeyConstraints();


		User::create([
			'name' => 'William',
			'email' => 'williamedr@gmail.com',
			'email_verified_at' => now(),
			'password' => Hash::make('123456'),
			'remember_token' => Str::random(10),
		]);


		// User::factory()->count(3)->create();

		Product::factory()->count(10)->create();


		$this->call([OrderSeeder::class]);

	}
}
