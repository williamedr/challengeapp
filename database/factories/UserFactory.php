<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	/**
	 * The current password being used by the factory.
	 */
	protected static ?string $password;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'name' => fake()->name(),
			'email' => fake()->unique()->safeEmail(),
			'email_verified_at' => now(),
			'password' => static::$password ??= Hash::make('secret'),
			'remember_token' => Str::random(10),
		];
	}


	public function configure()
	{
		return $this->afterCreating(function (User $user) {
			$role = Role::firstOrCreate(['name' => 'user']);

			$this->updateUser($user, $role, TRUE);
		});
	}


	// You can also define specific states for different roles
	public function admin()
	{
		return $this->afterCreating(function (User $user) {
			$role = Role::firstOrCreate(['name' => 'admin']);

			$this->updateUser($user, $role, FALSE);
		});
	}

	public function manager()
	{
		return $this->afterCreating(function (User $user) {
			$role = Role::firstOrCreate(['name' => 'manager']);

			$this->updateUser($user, $role, TRUE);
		});
	}


	/**
	 * Indicate that the model's email address should be unverified.
	 */
	public function unverified(): static
	{
		return $this->state(fn (array $attributes) => [
			'email_verified_at' => null,
		]);
	}


	private function updateUser($user, $role, $attachClient = FALSE) {
		$user->assignRole($role);

		if ($attachClient && $user->hasAnyRole(['manager', 'user'])) {
			$client = Client::inRandomOrder()->first();

			$exists = $user->clients()->where(['client_id' => $client->id])->exists();

			if (!$exists) {
				$user->clients()->attach($client->id);
			}
		}

		$name = $role->name;
		$email = $name . $user->id . '@example.com';

		$upd = [];
		$upd['name'] = ucfirst($name) . " {$user->id}";
		$upd['email'] = $email;

		$user->update($upd);

	}

}
