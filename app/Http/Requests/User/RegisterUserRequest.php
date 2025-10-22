<?php
namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;


class RegisterUserRequest extends BaseRequest {

	public function authorize() {
		return true;
	}


	public function rules() {
		return [
			'name' => 'required|string',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6',
			'c_password' => 'required|same:password',
		];
	}

}