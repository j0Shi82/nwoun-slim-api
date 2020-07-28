<?php
use DI\Bridge\Slim\Bridge as DIBridge;
use Dotenv\Dotenv;
use App\Controller\V1\Devtracker;
use App\Services\DB;

require __DIR__ . '/../vendor/autoload.php';

$app = DIBridge::create();

// get env vars
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app->group('/v1', function (Slim\Routing\RouteCollectorProxy $group) {
    $group->get('/devtracker', [Devtracker::class, 'get']);
});

$app->run();
