<?php
namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
	protected $model = Product::class;

	public function definition()
	{
		return [
			'name' => $this->faker->word(),
			'sku' => Str::upper(Str::random(10)),
			'price' => $this->faker->randomFloat(2, 1, 1000),
			'stock' => $this->faker->numberBetween(0, 100),
			'description' => $this->faker->sentence(),
		];
	}
}
