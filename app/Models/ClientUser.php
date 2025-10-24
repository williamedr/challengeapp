<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClientUser
 *
 * @property int $client_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Client $client
 * @property User $user
 *
 * @package App\Models
 */
class ClientUser extends Model
{
	protected $table = 'client_user';
	public $incrementing = false;

	protected $casts = [
		'client_id' => 'int',
		'user_id' => 'int'
	];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
