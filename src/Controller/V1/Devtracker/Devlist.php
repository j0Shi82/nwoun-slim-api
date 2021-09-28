<?php declare(strict_types=1);

namespace App\Controller\V1\Devtracker;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;

class Devlist
{
    /**
     * @var \App\Services\DB
     */
    private $db;

    public function __construct(\App\Services\DB $db)
    {
        $this->db = $db;
    }

    public function get(Request $request, Response $response)
    {
        $sql = 'SELECT COUNT(*) as post_count, MAX(UNIX_TIMESTAMP(t.date)) as last_active, t.dev_name, t.dev_id FROM devtracker as t GROUP BY dev_name ORDER BY dev_name';

        $response->getBody()->write(json_encode($this->db->sql_fetch_array($sql)));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
