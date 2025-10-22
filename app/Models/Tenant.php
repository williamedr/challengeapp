<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tenant
 * 
 * @property int $id
 * @property string $name
 * @property string $subdomain
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Invoice[] $invoices
 * @property Collection|OrderItem[] $order_items
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class Tenant extends Model
{
	protected $table = 'tenants';

	protected $fillable = [
		'name',
		'subdomain'
	];

	public function invoices()
	{
		return $this->hasMany(Invoice::class);
	}

	public function order_items()
	{
		return $this->hasMany(OrderItem::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
