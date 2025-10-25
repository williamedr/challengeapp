<?php

namespace App\Interfaces;

use App\Models\Client;
use App\Models\User;

interface ClientInterface
{

	public function all(array $filters);

	public function get(int $id);

	public function create(Client $client);

	public function update(Client $client);

	public function delete(Client $client);

	public function assignuser(Client $client, User $user);

}
