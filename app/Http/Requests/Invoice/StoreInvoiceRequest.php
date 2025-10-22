<?php
namespace App\Http\Requests\Invoice;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StoreInvoiceRequest extends BaseRequest {

	public function authorize() {
		return true;
	}


	public function rules() {
		return [
			// 'tenant_id' => 'required|numeric|min:0',
			'order_id' => ['required', Rule::exists('orders', 'id')],
			'invoice_number' => 'nullable|string|max:255',
			'total' => 'required|numeric|min:0',
			'issued_at' => 'nullable|date_format:Y-m-d H:i:s',
		];
	}
}