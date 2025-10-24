<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Interfaces\ProductInterface;
use App\Models\Product;

class ProductController extends BaseController
{
	private $product;


	public function __construct(ProductInterface $product)
	{
		$this->product = $product;
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$filters = [];
		$result = $this->product->all($filters);

		return $this->sendResponse($result);
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreProductRequest $request)
	{
		$record = new Product($request->validated());

		$result = $this->product->create($record);

		return $this->sendResponse($result);
	}


	/**
	 * Display the specified resource.
	 */
	public function show(Product $product)
	{
		return $this->sendResponse($product);
	}



	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateProductRequest $request, Product $product)
	{
		$product->fill($request->validated());

		$result = $this->product->update($product);

		return $this->sendResponse($result);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Product $product)
	{
		$result = $this->product->delete($product);

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
