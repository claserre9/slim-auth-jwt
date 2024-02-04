<?php

use App\controllers\UploadController;
use App\controllers\UserController;
use App\handlers\HttpErrorHandler;
use App\middlewares\AuthenticationMiddleware;
use DI\ContainerBuilder;
use Monolog\Logger;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Slim\Factory\AppFactory;
use Slim\Psr7\Stream;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();


try {
    $builder = new ContainerBuilder();
    $builder->addDefinitions(require __DIR__ . "/../config/container.php");
    $container = $builder->build();

    $app = AppFactory::createFromContainer($container);

    //Middlewares
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();

    $app->options('/{routes:.+}', function ($response) {
        return $response;
    });

    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', $_ENV['APP_URL_FRONTEND'])
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    $errorHandler = new HttpErrorHandler(
		$app->getCallableResolver(),
	    $app->getResponseFactory(), $app->getContainer()->get(Logger::class));
    $app->addErrorMiddleware(true, true, true)
        ->setDefaultErrorHandler($errorHandler);


    $app->group('/auth', function (RouteCollectorProxy $group) {
        $group->post('/register', [UserController::class, 'register']);
        $group->post('/login', [UserController::class, 'login']);
        $group->get('/activate', [UserController::class, 'activate']);
        $group->get('/activation/send', [UserController::class, 'sendActivationToken']);
        $group->post('/password/reset', [UserController::class, 'passwordReset']);
        $group->post('/password/confirm/{token}', [UserController::class, 'passwordResetConfirm']);
        $group->get('/refresh/token', [UserController::class, 'refreshToken']);
        $group->get('/me', [UserController::class, 'getLoggedInUser'])->add(new AuthenticationMiddleware());
        $group->get('/logout', [UserController::class, 'logout']);
    });

    $app->post('/upload/picture', [UploadController::class, 'upload'])->add(new AuthenticationMiddleware());
    //$app->get('/download/csv', [DownloadController::class, 'downloadCSV']);


    $app->get('/static/{path:.+}', function ($request, $response, $args) {
        $fullPath = __DIR__ . '/' . $args['path'];

        // Check if the file exists
        if (file_exists($fullPath) && is_file($fullPath)) {
            $stream = fopen($fullPath, 'r');
            return $response
                ->withHeader('Content-Type', mime_content_type($fullPath))
                ->withBody(new Stream($stream));
        } else {
            return $response->withStatus(404);
        }
    });


    $app->run();

} catch (Exception $e) {
    exit($e->getMessage().PHP_EOL);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
}
