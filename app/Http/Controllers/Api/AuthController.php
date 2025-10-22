<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
	public function register(RegisterUserRequest $request) {

		$user = User::create($request->validated());

		$token = $user->createToken('auth_token')->plainTextToken;

		$result = [
			'user' => $user,
			'access_token' => $token,
		];

		$message = 'User successfully registered!';

		return self::sendResponse($result, $message, 201);
	}


	public function login(LoginUserRequest $request) {

		$data = $request->validated();

		$user = User::where('email', $data['email'])->first();

		if (!$user || !Hash::check($data['password'], $user->password)) {
			self::sendError('No valid credentials.', [], 401);
		}

		$token = $user->createToken('auth_token')->plainTextToken;

		$result = [
			'user' => $user,
			'access_token' => $token,
		];

		$message = 'User successfully logged!';

		return self::sendResponse($result, $message, 200);
	}


	public function logout(Request $request)
    {
		$user = $request->user();

		$user->currentAccessToken()->delete();

		return self::sendResponse(true, 'Logged out', 200);
    }

}
