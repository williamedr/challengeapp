<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Client;


class CheckClient
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{

		$user = $request->user();

		if ($user->clients()->exists()) {

			if ($user->clients()->count() == 1) {
				$client_id = $user->clients[0]->id;

			} else {
				return response([
					'success' => false,
					'code' => 422,
					'message' => "Client Id (client_id) parameter is required.",
				], 422);

			}

			$client = Client::findOrFail($client_id);

			if (empty($client)) {
				return response([
					'success' => false,
					'code' => 404,
					'message' => "Client not found.",
				], 404);
			}

			$request['client_id'] = $client_id;
		}

		return $next($request);

	}
}
