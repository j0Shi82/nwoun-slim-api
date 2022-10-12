<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as SlimResponse;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\Cache\Marshaller\DefaultMarshaller;

class Cache
{
    /**
     * @var Symfony\Component\Cache\Adapter\FilesystemAdapter
     */
    private $cache;

    public function __construct()
    {
        $this->headerCache = new FilesystemAdapter('header', 3600, __DIR__ . '/../../cache', new DefaultMarshaller());
        $this->bodyCache = new FilesystemAdapter('body', 3600, __DIR__ . '/../../cache');
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (
            $request->getMethod() === 'GET'
            && $request->getUri()->getPath() !== '/v1/auctions/assignment'
            && $request->getUri()->getPath() !== '/v1/auth/login'
            && $request->getHeaders()['Cache-Control'][0] !== 'no-cache'
        ) {
            $response = null;
            $cacheKey = md5($request->getUri()->getPath() . $request->getUri()->getQuery() . $request->getMethod());
            $headers = $this->headerCache->get($cacheKey, function (ItemInterface $item) use ($handler, $request, &$response) {
                $item->expiresAfter(3600);

                $response = $handler->handle($request);

                return $response->getHeaders();
            });

            $body = $this->bodyCache->get($cacheKey, function (ItemInterface $item) use ($handler, $request, &$response) {
                $item->expiresAfter(3600);

                if ($reponse === null) {
                    $response = $handler->handle($request);
                }

                return $response->getBody()->__toString();
            });

            $response = new SlimResponse();
            $response->getBody()->write($body);
            foreach ($headers as $key => $values) {
                $response = $response->withHeader($key, $values[0]);
            };

            return $response->withHeader('Cache-Control', 'max-age='.round($this->headerCache->getItem($cacheKey)->getMetadata()['expiry'] - microtime(true)).', must-revalidate');
        }

        $response = $handler->handle($request);

        return $response;
    }
}
