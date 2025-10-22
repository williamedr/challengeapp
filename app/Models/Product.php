<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $sku
 * @property float $price
 * @property int $stock
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Product extends Model
{
	use HasFactory;


	protected $table = 'products';

	protected $casts = [
		'price' => 'float',
		'stock' => 'int'
	];

	protected $fillable = [
		'name',
		'sku',
		'price',
		'stock',
		'description'
	];

}
