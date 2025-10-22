<?php
namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreOrderRequest extends BaseRequest {

	public function authorize() {
		return true;
	}


	public function rules() {
		return [
			// 'tenant_id' => 'required|numeric|min:0',
			'user_id' => ['required', Rule::exists('users', 'id')],
			'status' => ['required', new Enum(OrderStatus::class)],
			'total' => 'required|numeric|min:0',
		];
	}
}