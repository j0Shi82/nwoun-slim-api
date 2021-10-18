<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

return [
    'propel' => [
        'database' => [
            'connections' => [
                'crawl' => [
                    'adapter'    => 'mysql',
                    'classname'  => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn'        => 'mysql:host='.$_ENV['MYSQL_SERVERNAME_CRAWL'].';dbname='.$_ENV['MYSQL_DB_CRAWL'],
                    'user'       => $_ENV['MYSQL_USERNAME_CRAWL'],
                    'password'   => $_ENV['MYSQL_PASSWORD_CRAWL'],
                    'attributes' => [],
                    'settings'   => [
                        'charset' => 'utf8mb4',
                        'queries' => [
                            'utf8' => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci, COLLATION_CONNECTION = utf8mb4_unicode_ci, COLLATION_DATABASE = utf8mb4_unicode_ci, COLLATION_SERVER = utf8mb4_unicode_ci'
                        ]
                    ]
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'crawl',
            'connections' => ['crawl']
        ],
        'generator' => [
            'defaultConnection' => 'crawl',
            'connections' => ['crawl']
        ]
    ]
];
