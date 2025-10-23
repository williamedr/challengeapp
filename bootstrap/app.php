<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__.'/../routes/web.php',
		api: __DIR__.'/../routes/api.php',
		commands: __DIR__.'/../routes/console.php',
		health: '/up',
	)
	->withMiddleware(function (Middleware $middleware) {
		//
	})
	->withExceptions(function (Exceptions $exceptions) {
		$exceptions->renderable(function (NotFoundHttpException $e, $request) {
			if ($request->is('api/*')) {
				$response['success'] = false;
				$response['message'] = 'Record not found.';
				$response['endpoint'] = $request->path();

				return response()->json($response, 404);
			}

			throw $e;
		});

	})->create();
