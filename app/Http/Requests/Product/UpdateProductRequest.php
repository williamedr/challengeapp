<?php
namespace App\Http\Requests;

namespace App\Http\Requests\Product;


class UpdateProductRequest extends FormRequest {

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