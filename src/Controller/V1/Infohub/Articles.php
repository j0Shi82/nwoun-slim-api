<?php

declare(strict_types=1);

namespace App\Controller\V1\Infohub;

use App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Schema\Crawl\Tag\TagQuery;
use App\Schema\Crawl\Article\ArticleQuery;
use JBBCode\DefaultCodeDefinitionSet;

class Articles extends BaseController
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
            'types' => $this->requestHelper->variable('types', 'official,discussion,news,guides,media,social'),
            'page' => $this->requestHelper->variable('page', 1),
            'site' => $this->requestHelper->variable('site', ''),
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
        if ($data_ary['limit'] < 10) {
            $data_ary['limit'] = 10;
        }

        if ($data_ary['page'] < 1) {
            $data_ary['page'] = 1;
        }

        $types = explode(',', $data_ary['types']);
        // filter invalid types
        $types = array_filter($types, function ($el) {
            return in_array($el, ['official','discussion','news','media','social','guides']);
        });

        // no types no result
        if (count($types) === 0) {
            $response->getBody()->write(json_encode([]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('charset', 'utf-8');
        }

        if (count($data_ary['tags']) > 0) {
            $this->db->query("SET SQL_BIG_SELECTS=1");
            $sql = "
                (
                    SELECT GROUP_CONCAT(DISTINCT a.site) as site, a.link, a.title, COUNT(DISTINCT a.id) as count, a.ts, a.type 
                    FROM 
                        (
                                SELECT article_tags.* 
                                FROM article_tags, tag 
                                WHERE tag.id IN (" . implode(",", $data_ary['tags']) . ") AND tag.id = article_tags.tag_id 
                                GROUP BY article_tags.tag_id, article_tags.article_id 
                            UNION DISTINCT 
                                SELECT article_title_tags.* 
                                FROM article_title_tags, tag 
                                WHERE tag.id IN (" . implode(",", $data_ary['tags']) . ") AND tag.id = article_title_tags.tag_id 
                                GROUP BY article_title_tags.tag_id, article_title_tags.article_id
                        ) as atags, 
                        article as a 
                    WHERE 
                        atags.article_id = a.id 
                        AND a.type IN ('" . implode("','", $types) . "')
                        AND site IN ('arcgamespc','arcgamesxbox','arcgamesps4') 
                        " . ($data_ary['site'] !== "" ? "AND site = \"" . $data_ary['site'] . "\"" : "") . "
                    GROUP BY a.ts, a.title 
                    HAVING count >= " . count($data_ary['tags']) . "
                )
                UNION 
                (
                    SELECT a.site, a.link, a.title, COUNT(DISTINCT a.id) as count, a.ts, a.type 
                    FROM 
                        (
                                SELECT article_tags.* 
                                FROM article_tags, tag 
                                WHERE tag.id IN (" . implode(",", $data_ary['tags']) . ") AND tag.id = article_tags.tag_id 
                                GROUP BY article_tags.tag_id, article_tags.article_id 
                            UNION DISTINCT 
                                SELECT article_title_tags.* 
                                FROM article_title_tags, tag 
                                WHERE tag.id IN (" . implode(",", $data_ary['tags']) . ") AND tag.id = article_title_tags.tag_id 
                                GROUP BY article_title_tags.tag_id, article_title_tags.article_id
                        ) as atags, 
                        article as a 
                    WHERE 
                        atags.article_id = a.id 
                        AND a.type IN ('" . implode("','", $types) . "')
                        AND site NOT IN ('arcgamespc','arcgamesxbox','arcgamesps4') 
                        " . ($data_ary['site'] !== "" ? "AND site = \"" . $data_ary['site'] . "\"" : "") . "
                    GROUP BY a.id 
                    HAVING count >= " . count($data_ary['tags']) . "
                )
                ORDER BY ts DESC 
                LIMIT " . ($data_ary['limit'] * ($data_ary['page'] - 1)) . "," . $data_ary['limit'] . ";
            ";
        // $sql = "
            //     (
            //         SELECT GROUP_CONCAT(DISTINCT a.site) as site, a.link, a.title, COUNT(DISTINCT a.id) as count, a.ts, a.type
            //         FROM article as a, article_tags as atags, article_title_tags as ttags, tag as t
            //         WHERE
            //             (atags.article_id = a.id OR ttags.article_id = a.id)
            //             AND atags.tag_id = t.id
            //             AND ttags.tag_id = t.id
            //             AND a.type IN ('" . implode("','", $types) . "')
            //             AND site IN ('arcgamespc','arcgamesxbox','arcgamesps4')
            //             AND t.id IN (" . implode(",", $data_ary['tags']) . ")
            //         GROUP BY a.ts, a.title
            //         HAVING count >= " . count($data_ary['tags']) . "
            //     )
            //         UNION
            //     (
            //         SELECT a.site, a.link, a.title, COUNT(*) as count, a.ts, a.type
            //         FROM article as a, article_tags as atags, article_title_tags as ttags, tag as t
            //         WHERE
            //             (atags.article_id = a.id OR ttags.article_id = a.id)
            //             AND atags.tag_id = t.id
            //             AND ttags.tag_id = t.id
            //             AND a.type IN ('" . implode("','", $types) . "')
            //             AND site NOT IN ('arcgamespc','arcgamesxbox','arcgamesps4')
            //             AND t.id IN (" . implode(",", $data_ary['tags']) . ")
            //         GROUP BY a.id
            //         HAVING count >= " . count($data_ary['tags']) . "
            //     )
            //     ORDER BY ts DESC
            //     LIMIT " . ($data_ary['limit'] * ($data_ary['page'] - 1)) . "," . $data_ary['limit'] . ";
        // ";
        } else {
            $sql = "
                (
                    SELECT GROUP_CONCAT(site) as site, link, title, ts, type
                    FROM article as a 
                    WHERE 
                        a.type IN ('" . implode("','", $types) . "') 
                        AND site IN ('arcgamespc','arcgamesxbox','arcgamesps4')
                        " . ($data_ary['site'] !== "" ? "AND site = \"" . $data_ary['site'] . "\"" : "") . "
                    GROUP BY ts, title
                )
                    UNION
                (
                    SELECT site, link, title, ts, type
                    FROM article as a
                    WHERE 
                        a.type IN ('" . implode("','", $types) . "') 
                        AND site NOT IN ('arcgamespc','arcgamesxbox','arcgamesps4')
                        " . ($data_ary['site'] !== "" ? "AND site = \"" . $data_ary['site'] . "\"" : "") . "
                ) 
                    ORDER BY ts DESC 
                    LIMIT " . ($data_ary['limit'] * ($data_ary['page'] - 1)) . "," . $data_ary['limit'];
        }

        $results = $this->db->sql_fetch_array($sql);
        $results = array_map(function ($row) {
            return [
                'site' => $row['site'],
                'title' => html_entity_decode($row['title']),
                'link' => $row['link'],
                'timestamp' => intval($row['ts']),
                'type' => $row['type'],
            ];
        }, $results);

        $response->getBody()->write(json_encode($results));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }

    public function get_sites(Request $request, Response $response)
    {
        $response->getBody()->write(json_encode(ArticleQuery::create()->select(['link', 'site'])->groupBySite()->find()->getData()));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }

    public function get_tags(Request $request, Response $response)
    {
        $tags = TagQuery::create()->select(['id', 'term'])->orderByTerm()->find();

        $response->getBody()->write(json_encode($tags->toArray()));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
