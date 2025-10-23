<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Interfaces\ClientInterface;
use App\Models\Client;

class ClientController extends BaseController
{
	private $client;


	public function __construct(ClientInterface $client)
	{
		$this->client = $client;
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$filters = [];
		$result = $this->client->all($filters);

		return $this->sendResponse($result);
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreClientRequest $request)
	{
		$record = new Client($request->validated());

		$result = $this->client->create($record);

		return $this->sendResponse($result);
	}


	/**
	 * Display the specified resource.
	 */
	public function show(Client $client)
	{
		return $this->sendResponse($client);
	}



	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateClientRequest $request, Client $client)
	{
		$client->fill($request->validated());

		$result = $this->client->update($client);

		return $this->sendResponse($result);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Client $client)
	{
		$result = $this->client->delete($client);

		return $this->sendResponse($result);
	}



	/**
	 * Display the client orders.
	 */
	public function orders(Client $client)
	{
		return $this->sendResponse($client->orders);
	}



	/**
	 * Return the model create form.
	 */
	public function create()
	{
		return '';
	}


	/**
	 * Return the model edit form.
	 */
	public function edit()
	{
		return '';
	}


}
