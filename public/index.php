<?php
use DI\Bridge\Slim\Bridge as DIBridge;
use Dotenv\Dotenv;
use App\Controller\V1\Devtracker;
use App\Services\DB;
use Slim\Exception\HttpNotFoundException;
use App\Middleware\Cors;

require __DIR__ . '/../vendor/autoload.php';

$app = DIBridge::create();

// get env vars
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$app->group('/v1', function (Slim\Routing\RouteCollectorProxy $group) {
    $group->get('/devtracker', [Devtracker::class, 'get']);
    $group->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
})->add(new Cors());

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
})->add(new Cors());

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
    throw new HttpNotFoundException($request);
});

$app->run();
