<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response as SlimResponse;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use UnexpectedValueException;

class Auth
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        //eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJ1c2VybmFtZSI6ImFkbWluIiwidXNlcmlkIjoxLCJpYXQiOjE2NjU2MDcxMjgsImV4cCI6MTY2ODE5OTEyOH0.EZXS3bVRVwGmG3ubaorF55jo0dIdNKfS_ogv_6VEl4Bl_SvhvOJ2D6JYwm4E9PqPxO2D5mN8RqC-QSF1SXYHxyU-3MBHI491fSQRSAVXwB_uSEjS26jXUERotSy7a5XJMHIYxOh7YQNqt_lfo7SA-8WSyk67vD-LykO_Jbt8mxIAJ1CeB5MtBlJEtNrzND7Erw6zgzn6aWprjeSxCrhUZiaTbtN6_OYKBMh7QFI-0iQHfnr13oRZB2NemnGxFsOm7aMI6encYeH3p_Cqm0EzgcKR6XJ2cNxHX2woXJ6fa09yEChlWMMPpCe9vZ_kL9Z7G-D0exX1TiVwj7cVLpdQldzcNQF08Vj1gbq75tlYdzRjWAs2pBaNEqYg0lZjBIDM6KTbEYfvW5W9pXBcHRjSVzTMqkiYf0VTo_IEpVfTvAq2C-1sprVvWKJzdMr-DwQhf7YIOQT9pD_X_VL_dl_nCXD2B1Kt5JWF9FuNauxalLqpUTX3RwDS1CApHpFgTk0GKo5GuDNJS7lqiQDLWEWf8DoK2Y_qyuNYNIYkWt4LmHb_D3Lt0dnhHvLL_czbPSuFQ7221UXHWNSvx1fFozXsxIbRwcitaK55cwChutCxHTBLf1mFuIMa3TVUfHT_MeG1hyWmDDjIxcU2cotr96864VeauiyDooku7T4fL3cePh8

        if (is_null($request->getCookieParams()['jwt'])) {
            $response = new SlimResponse();
            $response->getBody()->write(json_encode([
                'status' => 401,
                'status_msg' => 'bad credentials'
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('charset', 'utf-8');
        };

        $privateKeyFile = realpath(__DIR__ . '/../../key/gond-tools.rsa');
        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyFile));
        $publicKey = openssl_pkey_get_details($privateKey)['key'];

        try {
            $decoded = JWT::decode($request->getCookieParams()['jwt'], new Key($publicKey, 'RS256'));
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
                'status' => 400,
                'status_msg' => 'bad request payload'
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('charset', 'utf-8');
        } catch (\Exception $e) {
            throw $e;
            $response = new SlimResponse();
            $response->getBody()->write(json_encode([
                'status' => 401,
                'status_msg' => 'unknown error'
            ]));
        }

        $response = $handler->handle($request);
        return $response;
    }
}
