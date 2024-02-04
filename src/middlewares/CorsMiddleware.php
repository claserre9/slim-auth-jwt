<?php

namespace App\middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class CorsMiddleware
{
	public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
	{
		$response = $handler->handle($request);
		$response
			->withHeader('Access-Control-Allow-Origin', $_ENV['APP_URL_FRONTEND'])
			->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
			->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');

		return $handler->handle($request);
	}

}