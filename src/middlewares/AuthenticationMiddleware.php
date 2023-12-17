<?php

namespace App\middlewares;

use App\helpers\JWTHelpers;
use App\utils\encoders\JWTTokenEncoder;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpUnauthorizedException;

class AuthenticationMiddleware
{
    /**
     * Execute the PHP function.
     *
     * @param Request $request The request object.
     * @param RequestHandler $handler The request handler object.
     * @throws HttpUnauthorizedException If the token is invalid or the decoding fails.
     * @return ResponseInterface The response object.
     */
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        $header = $request->getHeaderLine('Cookie'); // gets the Cookie header
        $cookies = [];
        parse_str(strtr($header, ['&' => '%26', '+' => '%2B', ';' => '&']), $cookies);

        if (empty($cookies['accessToken'])) {
            throw new HttpUnauthorizedException($request, "No token provided");
        }

        try {
            $helper = new JWTHelpers(new JWTTokenEncoder());
            $decoded = $helper->decodeToken($cookies['accessToken'], $_ENV['JWT_SECRET'] );
            $username = $decoded["username"];
            $request = $request->withAttribute("username", $username);
        }catch (Exception $exception) {
            throw new HttpUnauthorizedException($request, $exception->getMessage());
        }


        return $handler->handle($request);

    }
}