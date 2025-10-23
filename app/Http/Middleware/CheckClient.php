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

		if (!empty($user->client_id)) {
			$client_id = $user->client_id;
			$request['client_id'] = $client_id;

			$client = Client::findOrFail($client_id);

			if (empty($client)) {
				return response([
					'client_id' => intval($request->client_id),
					'message' => "Client not found.",
				], 404);
			}
		}

		return $next($request);

	}
}
