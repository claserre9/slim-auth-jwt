<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
    $dotenv->safeLoad();
}

// Set up error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);


set_exception_handler(function ($e) {
    error_log($e->getMessage());
});

