<?php

namespace App\Interfaces;

use App\Models\Client;


interface ClientInterface
{

	public function all(array $filters);

	public function get(int $id);

	public function create(Client $client);

	public function update(Client $client);

	public function delete(Client $client);

}
