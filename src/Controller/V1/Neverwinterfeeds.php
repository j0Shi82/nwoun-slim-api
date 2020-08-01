<?php declare(strict_types=1);

namespace App\Controller\V1;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Feed;

class Neverwinterfeeds extends BaseController
{
    /**
     * @var int
     */
    private $limit = 20;

    /**
     * @var SimplePie
     */
    private $feed = null;

    /**
     * @param \App\Helpers\RequestHelper $requestHelper
     */
    public function __construct(\App\Helpers\RequestHelper $requestHelper, \SimplePie $feed)
    {
        parent::__construct($requestHelper);

        $this->feed = $feed;
        $this->feed->enable_cache(false);
    }

    /**
     * executes stuff that's needed for all get functions
     *
     * @param Request $request
     *
     * @return void
     */
    private function get_all(Request $request, String $feedUrl)
    {
        $this->attachRequestToRequestHelper($request);

        $this->feed->set_feed_url($feedUrl);
        $this->feed->init();
    }

    public function get_pc(Request $request, Response $response)
    {
        $this->get_all($request, "https://www.arcgames.com/en/games/neverwinter/news/rss");

        // define all possible GET data
        $data_ary = array(
            'limit' => $this->requestHelper->variable('limit', 20),
        );

        if ($data_ary['limit'] > 50) {
            $data_ary['limit'] = 50;
        }
        if ($data_ary['limit'] < 10) {
            $data_ary['limit'] = 10;
        }

        $data = array();

        $count = 0;
        foreach ($this->feed->get_items() as $item) {
            if ($count > $data_ary['limit']) {
                break;
            }
            $data[] = [
                    'link'            => $item->get_permalink(),
                    'title'             => $item->get_title(),
            ];
            $count++;
        }
        
        $response->getBody()->write(json_encode($data));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
