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
            'sites' => $this->requestHelper->variable('sites', ''),
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
            return in_array($el, ['official', 'discussion', 'news', 'media', 'social', 'guides']);
        });

        $sites = explode(',', $data_ary['sites']);
        // filter invalid types
        $sites = array_filter($sites, function ($el) {
            return in_array($el, ['youtube', 'twitch', 'arcgamesforum', 'nwreddit']);
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
                    SELECT 
                        GROUP_CONCAT(DISTINCT a.site) as site, 
                        CONCAT('https://www.playneverwinter.com/en/news-details/', a.article_id) as link, 
                        a.title, 
                        COUNT(DISTINCT a.id) as count, 
                        a.ts, 
                        CONCAT('[', GROUP_CONCAT(a.cats), ']') as cats, 
                        a.type 
                    FROM 
                        (
                                SELECT article_tags.* 
                                FROM article_tags, tag 
                                WHERE 
                                    tag.id IN (" . implode(",", $data_ary['tags']) . ") 
                                    AND tag.id = article_tags.tag_id 
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
                        AND site IN ('arcgamespc','arcgamesxbox','arcgamesps4','arcgamesnews') 
                        " . (count($sites) > 0 ? "AND site IN ('" . implode("','", $sites) . "')" : "") . "
                    GROUP BY a.article_id 
                    HAVING count >= " . count($data_ary['tags']) . "
                )
                UNION 
                (
                    SELECT a.site, a.link, a.title, COUNT(DISTINCT a.id) as count, a.ts, CONCAT('[', a.cats, ']') as cats, a.type 
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
                        AND site NOT IN ('arcgamespc','arcgamesxbox','arcgamesps4','arcgamesnews') 
                        " . (count($sites) > 0 ? "AND site IN ('" . implode("','", $sites) . "')" : "") . "
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
                    SELECT 
                        GROUP_CONCAT(site) as site, 
                        CONCAT('https://www.playneverwinter.com/en/news-details/', article_id) as link, 
                        title, 
                        ts, 
                        CONCAT('[', GROUP_CONCAT(cats), ']') as cats, 
                        type
                    FROM article as a 
                    WHERE 
                        a.type IN ('" . implode("','", $types) . "') 
                        AND site IN ('arcgamespc','arcgamesxbox','arcgamesps4','arcgamesnews')
                        " . (count($sites) > 0 ? "AND site IN ('" . implode("','", $sites) . "')" : "") . "
                    GROUP BY article_id
                )
                    UNION
                (
                    SELECT site, link, title, ts, CONCAT('[', cats, ']') as cats, type 
                    FROM article as a
                    WHERE 
                        a.type IN ('" . implode("','", $types) . "') 
                        AND site NOT IN ('arcgamespc','arcgamesxbox','arcgamesps4','arcgamesnews')
                        " . (count($sites) > 0 ? "AND site IN ('" . implode("','", $sites) . "')" : "") . "
                ) 
                    ORDER BY ts DESC 
                    LIMIT " . ($data_ary['limit'] * ($data_ary['page'] - 1)) . "," . $data_ary['limit'];
        }

        $results = $this->db->sql_fetch_array($sql);
        $results = array_map(function ($row) {
            $sites = explode(',', $row['site']);
            $cats = json_decode($row['cats']);
            // merge multidimensional array $cats into one array
            $cats = array_merge(...$cats);
            // push platform hints into sites array based on cats
            if (in_array('arcgamesnews', $sites) && in_array("nw-news", $cats)) {
                $sites[] = 'arcgamespc';
            }
            if (in_array('arcgamesnews', $sites) && in_array("nw-xbox", $cats)) {
                $sites[] = 'arcgamesxbox';
            }
            if (in_array('arcgamesnews', $sites) && in_array("nw-playstation", $cats)) {
                $sites[] = 'arcgamesps4';
            }
            // remove arcgamesnews from sites because we know should have platform hints in there instead
            if (($key = array_search('arcgamesnews', $sites)) !== false) {
                unset($sites[$key]);
            }
            // remove duplicates from sites array
            $sites = implode(",", array_unique($sites));

            return [
                'site' => $sites,
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