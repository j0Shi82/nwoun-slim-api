<?php

declare(strict_types=1);

namespace App\Controller\V1\Auth;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Schema\Crawl\User\UserQuery;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Services\Auth as AuthService;

class Login extends BaseController
{
    public function post(Request $request, Response $response)
    {
        $parseBody = $request->getParsedBody();

        $user = UserQuery::create()->filterByUsername($parseBody['username'] ?? '')->filterByPassword(hash('sha256', $parseBody['password'] ?? ''))->findOne();
        if (is_null($user)) {
            $response->getBody()->write(json_encode([
                'status' => 401,
                'status_msg' => 'bad credentials'
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('charset', 'utf-8')
                ->withStatus(401);
        };

        $jwt = AuthService::encode([
            'username' => $user->getUsername(),
            'userid' => $user->getId(),
        ]);

        $response->getBody()->write($jwt);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Set-Cookie', 'jwt=' . $jwt . '; Max-Age=' . $maxAge)
            ->withHeader('charset', 'utf-8');
    }
}
