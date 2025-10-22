<?php
namespace App\Http\Requests\Order;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateOrderItemRequest extends BaseRequest {

	public function authorize() {
		return true;
	}


	public function rules() {
		return [
			// 'tenant_id' => 'required|numeric|min:0',
			'order_id' => ['required', Rule::exists('orders', 'id')],
			'product_id' => ['required', Rule::exists('products', 'id')],
			'quantity' => 'required|int|min:1',
			'unit_price' => 'required|numeric|min:0',
			'subtotal' => 'required|numeric|min:0',
		];
	}
}