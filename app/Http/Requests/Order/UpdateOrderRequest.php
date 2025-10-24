<?php
namespace App\Http\Requests\Order;

use App\Enums\OrderStatus;
use App\Http\Requests\BaseRequest;
use App\Rules\ClientUserRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateOrderRequest extends BaseRequest {

	public function authorize() {
		return true;
	}


	public function rules() {
		$user = Auth::user();

		return [
			'client_id' => ['required', new ClientUserRule($user)],
			'user_id' => ['required', Rule::in([$user->id])],
			'status' => ['required', new Enum(OrderStatus::class)],
			'order_items.*.id' => 'integer|min:1',
			'order_items.*.product_id' => 'required|exists:products,id',
			'order_items.*.quantity' => 'required|integer|min:1',
		];
	}
}