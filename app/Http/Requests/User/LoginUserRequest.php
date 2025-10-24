<?php
namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;


class LoginUserRequest extends BaseRequest {

	public function authorize() {
		return true;
	}


	public function rules() {
		return [
			'email' => 'required|email',
			'password' => 'required'
		];
	}

}