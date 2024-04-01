<?php

use App\EntityManagerFactory;
use App\utils\mailers\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPMailer\PHPMailer\PHPMailer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Variable Definitions
 *
 * This file contains the definitions for several variables used in the project.
 * Each variable is documented with its name, type, and a brief description.
 */
$definitions = [

	"app.db" => "mysqli://root@localhost:3306/slim-jwt-db",
	"app.url" => "http://localhost:8080",
	"app.debug" => true,

	FilesystemLoader::class => DI\create()->constructor(__DIR__."/../src/templates"),
	Environment::class => DI\create()->constructor(DI\get(FilesystemLoader::class)),

	EntityManagerInterface::class => DI\factory([EntityManagerFactory::class, 'create']),

	StreamHandler::class => DI\create()->constructor(__DIR__ . "/../var/log/app.log", Logger::ERROR),
	Logger::class => DI\create()->constructor('app.log', [DI\get(StreamHandler::class)]),

	PHPMailer::class => DI\create()->constructor(),
	MailService::class => DI\create()
		->constructor(DI\get(PHPMailer::class))
		->method("setHost", $_ENV["SMTP_GOOGLE_HOST"])
		->method("setUsername", $_ENV["SMTP_GOOGLE_USERNAME"])
		->method("setPassword", $_ENV["SMTP_GOOGLE_PASSWORD"])
		->method("setPort", $_ENV["SMTP_GOOGLE_PORT"])
		->method("setSender", $_ENV["SMTP_GOOGLE_USERNAME"])
		->method("setSenderName", $_ENV["SMTP_GOOGLE_NAME"]),
];


return $definitions;
