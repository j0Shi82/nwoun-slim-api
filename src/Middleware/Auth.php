<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as SlimResponse;
use App\Schema\Crawl\User\UserQuery;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use App\Services\Auth as AuthService;
use UnexpectedValueException;

class Auth
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        try {
            $decoded = AuthService::decode($request);

            $user = UserQuery::create()->filterById($decoded->userid)->findOne();
            if (is_null($user)) {
                $response = new SlimResponse();
                $response->getBody()->write(json_encode([
                    'status' => 401,
                    'status_msg' => 'user not found'
                ]));
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withHeader('charset', 'utf-8')
                    ->withStatus(401);
            };

            $jwt = AuthService::encode([
                'username' => $decoded->username,
                'userid' => $decoded->userid,
            ]);

            $response = $handler->handle($request);
            return $response
                ->withHeader('Set-Cookie', 'jwt=' . $jwt . '; Max-Age=' . $maxAge);
        } catch (ExpiredException $e) {
            $response = new SlimResponse();
            $response->getBody()->write(json_encode([
                'status' => 401,
                'status_msg' => 'login expired'
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('charset', 'utf-8');
        } catch (UnexpectedValueException $e) {
            $response = new SlimResponse();
            $response->getBody()->write(json_encode([
                'status' => 401,
                'status_msg' => 'credential error',
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('charset', 'utf-8');
        } catch (\Exception $e) {
            throw $e;
            $response = new SlimResponse();
            $response->getBody()->write(json_encode([
                'status' => 500,
                'status_msg' => 'unknown error'
            ]));
        }
    }
}
