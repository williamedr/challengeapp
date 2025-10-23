<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 *
 * @property int $id
 * @property int|null $client_id
 * @property int $order_id
 * @property string $invoice_number
 * @property float $total
 * @property Carbon|null $issued_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Order $order
 * @property Tenant|null $tenant
 *
 * @package App\Models
 */
class Invoice extends Model
{
	use HasFactory;


	protected $table = 'invoices';

	protected $casts = [
		'client_id' => 'int',
		'order_id' => 'int',
		'total' => 'float',
		'issued_at' => 'datetime'
	];

	protected $fillable = [
		'client_id',
		'order_id',
		'invoice_number',
		'total',
		'issued_at'
	];

	// protected $with = ['order'];


	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}
}
