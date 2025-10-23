<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @property int $id
 * @property int|null $client_id
 * @property int $user_id
 * @property string $status
 * @property float $total
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Tenant|null $tenant
 * @property User $user
 * @property Collection|Invoice[] $invoices
 * @property Collection|OrderItem[] $order_items
 *
 * @package App\Models
 */
class Order extends Model
{
	use HasFactory;


	protected $table = 'orders';

	protected $casts = [
		'client_id' => 'int',
		'user_id' => 'int',
		'total' => 'float'
	];

	protected $fillable = [
		'client_id',
		'user_id',
		'status',
		'total'
	];

    protected $with = [
		'orderItems',
		// 'invoices',
	];


	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function invoices()
	{
		return $this->hasMany(Invoice::class);
	}

	public function orderItems()
	{
		return $this->hasMany(OrderItem::class);
	}
}
