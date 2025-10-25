<?php
namespace App\Repositories;

use App\Interfaces\ClientInterface;
use App\Models\Client;
use App\Models\ClientUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class ClientRepository implements ClientInterface
{
	public $client;

	public function __construct(Client $client)
	{
		$this->client = $client;
	}


	public function all($filters = [])
	{
		$query = $this->client;

		if (empty($filters)) {
			$query = $this->client;
		} else {
			$query = $this->client->where($filters);
		}

		$result = $query->get();

		return $result;
	}

	public function get(int $id)
	{
		return $this->client->findOrFail($id);
	}

	public function create(Client $client)
	{
		$client->save();

		return $client;
	}

	public function update(Client $client)
	{
		$client->save();

		return $client;
	}

	public function delete(Client $client)
	{
		$client->delete();

		return $client;
	}

	public function assignuser(Client $client, User $user)
	{
		if ($user->hasRole('admin')) {
			throw new AccessDeniedException('');
		}


		$authUser = Auth::user();

		if ($authUser->hasRole('user')) {
			throw new AccessDeniedException('');
		}

		if ($authUser->hasRole('manager')) {
			$userClient = $authUser->clients()->find($client->id);

			if (empty($userClient)) {
				throw new AccessDeniedException('Access Denied for this user for the Client.');
			}
		}


		$result['client_id'] = $client->id;
		$result['user_id'] = $user->id;

		$cond['client_id'] = $client->id;
		$cond['user_id'] = $user->id;

		$clientUser = ClientUser::where($cond)->first();

		if (empty($clientUser)) {
			$user->clients()->attach($client->id);
		}

		return $result;
	}

}
