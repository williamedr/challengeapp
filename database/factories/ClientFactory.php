<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

class ClientFactory extends Factory
{
	protected $model = Client::class;

	public function definition()
	{
		return [
            'name' => fake()->company(),
            'email' => fake()->unique()->safeEmail(),
		];
	}


	public function configure()
	{
		return $this->afterCreating(function (Client $client) {
			$client->update([
				'domain' => 'domain' . $client->id
			]);
		});
	}

}
