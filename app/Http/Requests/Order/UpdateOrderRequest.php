<?php
namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderRequest extends BaseRequest {

	public function authorize() {
		return true;
	}


	public function rules() {
		return [
			'client_id' => ['required', Rule::exists('clients', 'id')],
			'user_id' => ['required', Rule::exists('users', 'id')],
			'status' => ['required', new Enum(OrderStatus::class)],
			'total' => 'required|numeric|min:0',
		];
	}
}