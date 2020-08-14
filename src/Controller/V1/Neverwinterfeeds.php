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
        $this->feed->set_timeout(5);
        $this->feed->enable_cache(true);
        $this->feed->set_cache_location(realpath('../cache'));
        $this->feed->set_cache_duration(3600);
    }

    /**
     * executes stuff that's needed for all get functions
     *
     * @param Request $request
     * @param String $feedUrl
     *
     * @return void
     */
    private function get(Request $request, Response $response, String $feedUrl, String $dataCallbackFunc)
    {
        $this->attachRequestToRequestHelper($request);

        $this->feed->set_feed_url($feedUrl);
        $this->feed->init();

        $data_ary = array(
            'limit' => $this->requestHelper->variable('limit', 20),
        );

        if ($data_ary['limit'] > 50) {
            $data_ary['limit'] = 50;
        }
        if ($data_ary['limit'] < 10) {
            $data_ary['limit'] = 10;
        }

        if ($this->feed->error() !== null) {
            $response->getBody()->write(
                json_encode(
                    [
                        'errorType' => 'feedFetch',
                        'errorDesc' => $this->feed->error(),
                    ]
                )
            );
            return $response->withStatus(500);
        }

        $data = call_user_func(array($this, $dataCallbackFunc), $data_ary['limit']);
        
        $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }

    /**
     * structures and returns data for arcgames feeds
     *
     * @param int $limit
     *
     * @return array
     */
    private function get_arcgames_data(int $limit) :array
    {
        $data = array();

        $count = 0;
        foreach ($this->feed->get_items() as $item) {
            if ($count > $limit) {
                break;
            }
            $data[] = [
                    'link'            => $item->get_permalink(),
                    'title'             => html_entity_decode($item->get_title()),
                    'ts'            => $item->get_date("U"),
            ];
            $count++;
        }

        return $data;
    }

    /**
     * structures and returns data for arcgames forum
     *
     * @param int $limit
     *
     * @return array
     */
    private function get_arcgames_forum_data(int $limit) :array
    {
        $data = array();

        $count = 0;
        foreach ($this->feed->get_items() as $item) {
            if ($count > $limit) {
                break;
            }
            $data[] = [
                    'link'            => $item->get_permalink(),
                    'title'             => html_entity_decode($item->get_title()),
                    'cat'       => $item->get_item_tags('', 'category')[0]['data'],
                    'ts'            => $item->get_date("U"),
            ];
            $count++;
        }

        return $data;
    }

    /**
     * structures and returns data for subreddits
     *
     * @param int $limit
     *
     * @return array
     */
    private function get_reddit_data(int $limit) :array
    {
        $data = array();

        $count = 0;
        foreach ($this->feed->get_items() as $item) {
            if ($count > $limit) {
                break;
            }
            $data[] = [
                    'link'            => $item->get_permalink(),
                    'title'           => html_entity_decode($item->get_title()),
                    'ts'            => $item->get_date("U"),
            ];
            $count++;
        }

        return $data;
    }

    public function get_pc(Request $request, Response $response) :Response
    {
        return $this->get($request, $response, "https://www.arcgames.com/en/games/neverwinter/news/rss", "get_arcgames_data");
    }

    public function get_xbox(Request $request, Response $response) :Response
    {
        return $this->get($request, $response, "https://www.arcgames.com/en/games/xbox/neverwinter/news/rss", "get_arcgames_data");
    }

    public function get_ps4(Request $request, Response $response) :Response
    {
        return $this->get($request, $response, "https://www.arcgames.com/en/games/playstation/neverwinter/news/rss", "get_arcgames_data");
    }

    public function get_forum(Request $request, Response $response) :Response
    {
        return $this->get($request, $response, "https://forum.arcgames.com/neverwinter/discussions/feed.rss", "get_arcgames_forum_data");
    }

    public function get_reddit(Request $request, Response $response) :Response
    {
        return $this->get($request, $response, "https://www.reddit.com/r/Neverwinter.rss", "get_reddit_data");
    }
}
