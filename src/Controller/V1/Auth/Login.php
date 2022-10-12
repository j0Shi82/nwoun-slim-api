<?php

declare(strict_types=1);

namespace App\Controller\V1\Auth;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Schema\Crawl\User\UserQuery;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Login extends BaseController
{
    /**
     * @param \App\Helpers\RequestHelper $requestHelper
     *
     * @return void
     */
    public function __construct(\App\Helpers\RequestHelper $requestHelper)
    {
        parent::__construct($requestHelper);
    }

    public function securedEndpoint(Request $request, Response $response)
    {
        $response->getBody()->write(json_encode([
            'status' => 200,
            'status_msg' => 'secured route'
        ]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8')
            ->withStatus(200);
    }

    public function post(Request $request, Response $response)
    {
        $this->attachRequestToRequestHelper($request);

        // define all possible GET data
        $data_ary = array(
            'username' => $this->requestHelper->variable('username', ''),
            'password' => $this->requestHelper->variable('password', ''),
        );

        $user = UserQuery::create()->filterByUsername($data_ary['username'])->filterByPassword(hash('sha256', $data_ary['password']))->findOne();
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


        $privateKeyFile = realpath(__DIR__ . '/../../../../key/gond-tools.rsa');
        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyFile));
        $publicKey = openssl_pkey_get_details($privateKey)['key'];

        // $exp = time() + (30 * 24 * 60 * 60);
        $exp = time();
        $maxAge = $exp - time() + 120;
        $payload = [
            'username' => $data_ary['username'],
            'userid' => 1,
            'iat' => time(),
            'exp' => $exp
        ];

        $jwt = JWT::encode($payload, $privateKey, 'RS256');

        $response->getBody()->write($jwt);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Set-Cookie', 'jwt=' . $jwt . '; Max-Age=' . $maxAge)
            ->withHeader('charset', 'utf-8');
    }
}
