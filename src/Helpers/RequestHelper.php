<?php declare(strict_types=1);

namespace App\Helpers;

class RequestHelper
{
    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    private $request;

    /**
     * @var \App\Services\DB
     */
    private $db;

    public function __construct(\App\Services\DB $db)
    {
        $this->db = $db;
    }

    public function attachRequest(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function variable(String $name, $default, $escape = true)
    {
        $value = $default;
        $queryParams = $this->request->getQueryParams();
        if (isset($queryParams[$name]) && !empty($queryParams[$name])) {
            $value = $queryParams[$name];
        }

        if (gettype($default) === 'integer') {
            return $escape ? intval($value) : $value;
        } else {
            return $escape ? $this->db->escape($value) : $value;
        }
    }
}
