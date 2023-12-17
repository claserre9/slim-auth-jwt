<?php

namespace App\handlers;

use App\exceptions\DataValidationException;
use Psr\Http\Message\ResponseInterface;
use Slim\Handlers\ErrorHandler;
use Throwable;

/**
 * Class HttpErrorHandler
 *
 * This class extends the ErrorHandler class and handles HTTP error exceptions by returning a JSON response
 * with the appropriate status code, error type, and error message.
 */
class HttpErrorHandler extends ErrorHandler
{
    const ERROR_TYPES = [
        'Slim\Exception\HttpNotFoundException' => ['RESOURCE_NOT_FOUND', 404],
        'Slim\Exception\HttpMethodNotAllowedException' => ['NOT_ALLOWED', 405],
        'Slim\Exception\HttpUnauthorizedException' => ['UNAUTHENTICATED', 401],
        'Slim\Exception\HttpForbiddenException' => ['INSUFFICIENT_PRIVILEGES', 403],
        'Slim\Exception\HttpBadRequestException' => ['BAD_REQUEST', 400],
        'Slim\Exception\HttpNotImplementedException' => ['NOT_IMPLEMENTED', 501],
        'App\exceptions\DataValidationException' => ['DATA_VALIDATION_FAILED', 400],
    ];

    protected function respond(): ResponseInterface
    {
        $exception = $this->exception ?? null;
        $statusCode = 500;
        $type = 'SERVER_ERROR';
        $description = 'An internal error has occurred while processing your request.';

        if ($exception instanceof Throwable) {
            if (array_key_exists(get_class($exception), self::ERROR_TYPES)) {
                [$type, $statusCode] = self::ERROR_TYPES[get_class($exception)];
                if ($exception instanceof DataValidationException) {
                    $description = json_decode($exception->getMessage(), true);
                } else {
                    $description = $exception->getMessage();
                }
            }
        }

        $error = [
            'error' => [
                'statusCode' => $statusCode,
                'type' => $type,
                'message' => $description,
            ],
        ];
        if($_ENV['APP_DEBUG'] && $this->displayErrorDetails) {
            $error['error']['type'] = get_class($exception);
            $error['error']['description'] = $exception->getMessage();
            $error['error']['file'] = $exception->getFile();
        }

        if($_ENV['APP_DEBUG'] && $this->logErrors) {
            $this->logger->error($exception->getMessage());
        }

        $payload = json_encode($error, JSON_PRETTY_PRINT);

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }
}
