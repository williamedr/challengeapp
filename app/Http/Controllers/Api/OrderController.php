<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Repositories\OrderRepository;
use App\Models\Order;

class OrderController extends BaseController
{
	private $orderRepository;


	public function __construct(OrderRepository $orderRepository)
	{
		$this->orderRepository = $orderRepository;
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$filters = [];
		$result = $this->orderRepository->all($filters);

		return $this->sendResponse($result);
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreOrderRequest $request)
	{
		$record = new Order($request->validated());

		$result = $this->orderRepository->save($record);

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

		$result = $this->orderRepository->save($order);

		return $this->sendResponse($result);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Order $order)
	{
		$result = $this->orderRepository->delete($order);

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
