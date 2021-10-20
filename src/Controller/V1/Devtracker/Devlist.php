<?php declare(strict_types=1);

namespace App\Controller\V1\Devtracker;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;
use App\Schema\Crawl\Devtracker\DevtrackerQuery;

class Devlist
{
    public function get(Request $request, Response $response)
    {
        $devs = DevtrackerQuery::create()
            ->withColumn('Count(*)', 'post_count')
            ->withColumn('MAX(UNIX_TIMESTAMP(date))', 'last_active')
            ->groupByDevName()
            ->orderByDevName()
            ->select(array('post_count', 'last_active', 'dev_name', 'dev_id'))
            ->find();

        $response->getBody()->write(json_encode($devs->getData()));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
