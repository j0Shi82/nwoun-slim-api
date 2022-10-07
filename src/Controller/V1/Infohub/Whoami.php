<?php

declare(strict_types=1);

namespace App\Controller\V1\Infohub;

use App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Schema\Crawl\Tag\TagQuery;

class Whoami extends BaseController
{
    public function __construct(\App\Helpers\RequestHelper $requestHelper)
    {
        parent::__construct($requestHelper);
    }

    public function get(Request $request, Response $response)
    {
        $this->attachRequestToRequestHelper($request);

        $data_ary = array(
            'url' => $this->requestHelper->variable('url', ''),
        );

        $tags = TagQuery::create()
        ->find();

        $tag_id = null;
        $tag_name = null;

        foreach ($tags->getData() as $tag) {
            // this strips all non numeric non alpha chars from the term and converts it to lowercase with hyphens instead of spaces
            $url_from_term = strtolower(preg_replace("/\s/", "-", preg_replace("/[^0-9a-zA-Z\s]/", "", $tag->getTerm())));
            if ($data_ary['url'] === $url_from_term) {
                $tag_id = $tag->getId();
                $tag_name = $tag->getTerm();
            }
        }

        $response->getBody()->write(json_encode([
            'id' => $tag_id,
            'name' => $tag_name
        ]));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
