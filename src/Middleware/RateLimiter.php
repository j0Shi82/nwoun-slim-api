<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response as SlimResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use PalePurple\RateLimit\RateLimit;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use App\Helpers\RateLimitPSR6Adapter;

class RateLimiter
{
    /**
     * @var \Symfony\Component\Cache\Adapter\FilesystemAdapter
     */
    private $cache;


    /**
     * @var \App\Helpers\RateLimitPSR6Adapter
     */
    private $adapter;


    /**
     * @var \PalePurple\RateLimit\RateLimit
     */
    private $rateLimit;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->cache = new FilesystemAdapter('ratelimit', 3600, __DIR__ . '/../../cache');
        $this->adapter = new RateLimitPSR6Adapter($this->cache);

        $this->rateLimit = new RateLimit("loginratelimit", 3, 60 * 5, $this->adapter);
    }

    /**
     * __invoke
     *
     * @param  mixed $request
     * @param  mixed $handler
     *
     * @return Response
     */
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if ($this->rateLimit->check(md5($request->getAttribute('client-ip')))) {
            $response = $handler->handle($request);
            return $response;
        } else {
            $response = new SlimResponse();
            return $response->withStatus(429);
        }
    }
}
