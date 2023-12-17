<?php

namespace App\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler;
use Throwable;

class HttpErrorHandler extends ErrorHandler
{
    const ERROR_TYPES = [
        HttpNotFoundException::class => ['RESOURCE_NOT_FOUND', 404],
        HttpMethodNotAllowedException::class => ['NOT_ALLOWED', 405],
        HttpUnauthorizedException::class => ['UNAUTHENTICATED', 401],
        HttpForbiddenException::class => ['INSUFFICIENT_PRIVILEGES', 403],
        HttpBadRequestException::class => ['BAD_REQUEST', 400],
        HttpNotImplementedException::class => ['NOT_IMPLEMENTED', 501],
    ];

    protected function respond(): ResponseInterface
    {
        $exception = $this->exception;
        $statusCode = 500;
        $type = 'SERVER_ERROR';
        $description = 'An internal error has occurred while processing your request.';

        if ($exception instanceof HttpException) {
            $statusCode = $exception->getCode();
            $description = $exception->getMessage();

            if (array_key_exists(get_class($exception), self::ERROR_TYPES)) {
                [$type, $statusCode] = self::ERROR_TYPES[get_class($exception)];
            }
        }

        if (!$exception instanceof HttpException) {
            $description = $exception->getMessage();
        }

        $error = [
            'error' => [
                'statusCode' => $statusCode,
                'type' => $type,
                'message' => json_decode($description),
            ],
        ];

        $payload = json_encode($error, JSON_PRETTY_PRINT);

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }
}