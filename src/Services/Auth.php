<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Psr\Http\Message\ServerRequestInterface as Request;

class Auth
{
    /**
     * string $privateKeyFile
     */
    public const PRIVATE_KEY_FILE = __DIR__ . '/../../key/gond-tools.rsa';
    public const EXP = 30 * 24 * 60 * 60;

    private static function getPrivateKey(): \OpenSSLAsymmetricKey
    {
        return openssl_pkey_get_private(file_get_contents(realpath(self::PRIVATE_KEY_FILE)));
    }

    private static function getPublicKey(): string
    {
        return openssl_pkey_get_details(self::getPrivateKey())['key'];
    }

    private static function getBearerTokenFromAuthorizationHeader(Request $request): string|null
    {
        $headers = $request->getHeader('Authorization');
        $token = null;
        if (is_array($headers)) {
            foreach ($headers as $header) {
                if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
                    $token = $matches[1];
                    break;
                }
            }
        }

        return $token;
    }

    private static function getBearerToken(Request $request): string|null
    {
        $order = ['header', 'cookie', 'body', 'query'];
        $bearer = [
            'header' => self::getBearerTokenFromAuthorizationHeader($request),
            'cookie' => $request->getCookieParams()['bearer'] ?? null,
            'body' => $request->getParsedBody()['bearer'] ?? null,
            'query' => $request->getQueryParams()['bearer'] ?? null
        ];

        $tokens = array_filter(array_map(function ($el) use ($bearer) {
            return $bearer[$el];
        }, $order), function ($el) {
            return $el !== null;
        });
        sort($tokens);

        if (count($tokens)) {
            return $tokens[0];
        }

        return "";
    }

    public static function encode($payload): string
    {
        return JWT::encode(array_merge(
            $payload,
            [
                'iat' => time(),
                'exp' => time() + self::EXP
            ]
        ), self::getPrivateKey(), 'RS256');
    }

    public static function decode(Request $request): object
    {
        return JWT::decode(self::getBearerToken($request), new Key(self::getPublicKey(), 'RS256'));
    }
}
