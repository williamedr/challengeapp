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
 * Class Client
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $domain
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Order[] $orders
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Client extends Model
{
	use HasFactory;

	protected $table = 'clients';

	protected $fillable = [
		'name',
		'email',
		'domain'
	];

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function invoicecs()
	{
		return $this->hasMany(Invoice::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class)->withTimestamps();
	}
}
