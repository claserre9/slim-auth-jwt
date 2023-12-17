<?php

use App\EntityManagerFactory;
use App\utils\mailers\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Log\LoggerInterface;

/**
 * Variable Definitions
 *
 * This file contains definitions for various variables.
 *
 */
$definitions = [
    EntityManagerInterface::class => DI\factory([EntityManagerFactory::class, 'create']),
    PHPMailer::class => DI\create()->constructor(),

    StreamHandler::class => DI\create()->constructor(
        "var/log/app.log",
        Logger::ERROR
    ),

    Logger::class => DI\create()
        ->constructor(
            'app.log',
            [DI\get(StreamHandler::class)]
        ),

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
