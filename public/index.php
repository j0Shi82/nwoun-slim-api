<?php

error_reporting(E_ERROR | E_PARSE);

use DI\Bridge\Slim\Bridge as DIBridge;
use Dotenv\Dotenv;
use App\Application\Routes;
use App\Application\CorsErrorHandler;

require __DIR__ . '/../vendor/autoload.php';
require_once  __DIR__ . '/../src/Schema/generated-conf/config.php';

$app = DIBridge::create();

// get env vars
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app->addBodyParsingMiddleware();

if ($_ENV['ENV'] === 'dev') {
}

Routes::add($app);

// Instantiate Custom Error Handler
$errorHandler = new CorsErrorHandler($app->getCallableResolver(), $app->getResponseFactory());

$errorMiddleware = $app->addErrorMiddleware($_ENV['ENV'] === 'dev', true, true);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

$app->run();
