<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as SlimResponse;

class Compression
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        $accept_encodings = array_map(function ($n) { return trim($n); }, explode(',', $request->getHeader('Accept-Encoding')[0]));

        // if (in_array('br', $accept_encodings)) {
        //     // br encoding
        //     $encoded = new SlimResponse();
        //     $encoded->getBody()->write(brotli_compress($response->getBody(), 11));
        //     $response = $response->withHeader('content-encoding', 'br');
        //     return $response
        //         ->withHeader('content-encoding', 'br')
        //         ->withBody($encoded->getBody());
        // }

        if (in_array('gzip', $accept_encodings)) {
            // gzip encoding
            $encoded = new SlimResponse();
            $encoded->getBody()->write(gzencode($response->getBody(), 9));
            return $response
                ->withHeader('content-encoding', 'gzip')
                ->withBody($encoded->getBody());
        }

        return $response;
    }
}
