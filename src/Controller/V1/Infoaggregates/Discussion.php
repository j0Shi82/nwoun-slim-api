<?php declare(strict_types=1);

namespace App\Controller\V1\Infoaggregates;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;

class Discussion extends BaseController
{
    /**
     * @var \App\Services\DB
     */
    private $db;

    public function __construct(\App\Services\DB $db, \App\Helpers\RequestHelper $requestHelper)
    {
        parent::__construct($requestHelper);

        $this->db = $db;
        $this->db->connect('CRAWL');
    }

    public function get(Request $request, Response $response)
    {
        $this->attachRequestToRequestHelper($request);

        $data_ary = array(
            'limit' => $this->requestHelper->variable('limit', 50),
            'tag' => $this->requestHelper->variable('tag', 0),
        );

        if ($data_ary['limit'] > 100) {
            $data_ary['limit'] = 100;
        }
        if ($data_ary['limit'] < 20) {
            $data_ary['limit'] = 20;
        }

        if ($data_ary['tag'] !== 0) {
            $sql = "
                SELECT a.site, a.link, a.title FROM article as a, article_tags as atags, tag as t
                WHERE 
                    atags.article_id = a.id 
                    AND atags.tag_id = t.id 
                    AND a.type = 'discussion'
                    AND t.id = " . $data_ary['tag'] . "
                ORDER BY a.ts DESC
                LIMIT " . $data_ary['limit'] . "
            ";
        } else {
            $sql = "SELECT a.site, a.link, a.title FROM article as a WHERE a.type = 'discussion' ORDER BY a.ts DESC LIMIT " . $data_ary['limit'];
        }

        $response->getBody()->write(json_encode($this->db->sql_fetch_array($sql)));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }

    public function get_tags(Request $request, Response $response)
    {
        $sql = "SELECT t.term, t.id FROM tag as t ORDER BY t.term";

        $response->getBody()->write(json_encode($this->db->sql_fetch_array($sql)));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
