<?php
namespace App\Repositories;

use App\Interfaces\ClientInterface;
use App\Models\Client;


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

		if (!empty($filters)) {
			$query->where($filters);
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

}
