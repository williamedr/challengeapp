<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductController extends BaseController
{
	private $productRepository;


	public function __construct(ProductRepository $productRepository)
	{
		$this->productRepository = $productRepository;
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$filters = [];
		$result = $this->productRepository->all($filters);

		return $this->sendResponse($result);
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreProductRequest $request)
	{
		$record = new Product($request->validated());

		$result = $this->productRepository->save($record);

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

		$result = $this->productRepository->save($product);

		return $this->sendResponse($result);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Product $product)
	{
		$result = $this->productRepository->delete($product);

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


	/**
	 * Get custom query
	 */
	public function getCustomQuery()
	{
		$params = [];

		$result = $this->productRepository->customQuery($params);

		return $this->sendResponse($result);
	}


}
