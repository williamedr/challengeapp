<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest {

	protected $message = 'Validation Error';

	protected function setErrorMessage($message) {
		$this->message = $message;
	}


	/**
	 * Handle a failed validation attempt.
	 *
	 * @param  \Illuminate\Contracts\Validation\Validator  $validator
	 * @return void
	 *
	 * @throws \Illuminate\Http\Exceptions\HttpResponseException
	 */
	protected function failedValidation(Validator $validator)
	{
		$response = response()->json([
			'message' => $this->message,
			'errors' => $validator->errors()
		], 422);

		throw new \Illuminate\Http\Exceptions\HttpResponseException($response);
	}

}