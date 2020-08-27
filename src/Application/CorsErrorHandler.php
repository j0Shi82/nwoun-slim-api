<?php
namespace App\Application;

use Slim\Handlers\ErrorHandler;
use Psr\Http\Message\ResponseInterface;

class CorsErrorHandler extends ErrorHandler
{
    protected function respond(): ResponseInterface
    {
        return parent::respond()
        // ->withHeader('Access-Control-Allow-Origin', 'https://www.nwo-uncensored.com')
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }
}
