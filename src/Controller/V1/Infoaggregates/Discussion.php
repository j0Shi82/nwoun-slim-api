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
            'tags' => $this->requestHelper->variable('tags', ''),
        );

        if ($data_ary['tags'] !== '') {
            $data_ary['tags'] = explode(",", $data_ary['tags']);
            foreach ($data_ary['tags'] as &$tag) {
                $tag = intval($tag);
            }
        } else {
            $data_ary['tags'] = [];
        }

        if ($data_ary['limit'] > 100) {
            $data_ary['limit'] = 100;
        }
        if ($data_ary['limit'] < 20) {
            $data_ary['limit'] = 20;
        }

        if (count($data_ary['tags']) > 0) {
            $sql = "
                SELECT a.site, a.link, a.title, COUNT(*) as count
                FROM article as a, article_tags as atags, tag as t
                WHERE 
                    atags.article_id = a.id 
                    AND atags.tag_id = t.id 
                    AND a.type = 'discussion'
                    AND t.id IN (" . implode(",", $data_ary['tags']) . ")
                GROUP BY a.id
                HAVING count >= " . count($data_ary['tags']) . "
                ORDER BY a.ts DESC
                LIMIT " . $data_ary['limit'] . "
            ";
        } else {
            $sql = "SELECT a.site, a.link, a.title FROM article as a WHERE a.type = 'discussion' ORDER BY a.ts DESC LIMIT " . $data_ary['limit'];
        }

        $results = $this->db->sql_fetch_array($sql);
        foreach ($results as &$row) {
            $row['title'] = html_entity_decode($row['title']);
            $row[2] = html_entity_decode($row[2]);
        }

        $response->getBody()->write(json_encode($results));
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
