<?php
namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

class UpdateProductRequest extends BaseRequest {

	public function authorize() {
		return true;
	}


	public function rules() {
		return [
			'sku' => 'nullable|string',
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
			'price' => 'required|numeric|min:0',
			'stock' => 'required|integer|min:0',
		];
	}
}