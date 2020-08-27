<?php

error_reporting(E_ERROR | E_PARSE);

use DI\Bridge\Slim\Bridge as DIBridge;
use Dotenv\Dotenv;
use App\Application\Routes;

require __DIR__ . '/../vendor/autoload.php';

$app = DIBridge::create();

// get env vars
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

Routes::add($app);

$app->run();
