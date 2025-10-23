<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Interfaces\OrderInterface;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends BaseController
{
	private $order;


	public function __construct(OrderInterface $order)
	{
		$this->order = $order;
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$filters = $request->all();

		$result = $this->order->all($filters);

		return $this->sendResponse($result);
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreOrderRequest $request)
	{
		$record = new Order($request->validated());

		$result = $this->order->create($record);

		return $this->sendResponse($result);
	}


	/**
	 * Display the specified resource.
	 */
	public function show(Order $order)
	{
		return $this->sendResponse($order);
	}



	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateOrderRequest $request, Order $order)
	{
		$order->fill($request->validated());

		$result = $this->order->update($order);

		return $this->sendResponse($result);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Order $order)
	{
		$result = $this->order->delete($order);

		return $this->sendResponse($result);
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
