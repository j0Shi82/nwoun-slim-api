<?php

declare(strict_types=1);

namespace App\Controller\V1\Devtracker;

use App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;
use App\Schema\Crawl\Devtracker\DevtrackerQuery;

class Topiclist extends BaseController
{
    public function __construct(\App\Helpers\RequestHelper $requestHelper)
    {
        parent::__construct($requestHelper);
    }

    public function get(Request $request, Response $response)
    {
        $this->attachRequestToRequestHelper($request);

        // define all possible GET data
        $data_ary = array(
            'threshold' => $this->requestHelper->variable('threshold', 2),
        );

        $topics = DevtrackerQuery::create()
            ->withColumn('Count(*)', 'post_count')
            ->withColumn('MAX(UNIX_TIMESTAMP(date))', 'last_active')
            ->withColumn('Count(*)', 'postCount')
            ->withColumn('MAX(UNIX_TIMESTAMP(date))', 'lastActive')
            ->groupByDiscussionId()
            ->having('postCount >= ' . $data_ary['threshold'])
            ->orderBy('lastActive', 'DESC')
            ->select(array('post_count', 'discussion_id', 'discussion_name', 'postCount', 'discussionId', 'discussionName'))
            ->find()
            ->getData();

        $response->getBody()->write(json_encode($topics));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
