<?php

declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery;

class ItemDetails extends BaseController
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
            'item_def' => $this->requestHelper->variable('item_def', ''),
            'server' => $this->requestHelper->variable('server', 'GLOBAL')
        );

        if (empty($data_ary['item_def']) || empty($data_ary['server'])) {
            $response->getBody()->write("{\"message\":\"missing required parameters\",\"error\":400}");
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400)
                ->withHeader('charset', 'utf-8');
        }

        $result = AuctionAggregatesQuery::create()
            ->filterByItemDef($data_ary['item_def'])
            ->filterByServer($data_ary['server'])
            ->filterByCount(array('min' => 1))
            ->withColumn("DATE_FORMAT(inserted, '%Y-%m-%d')", 'insertedDate')
            ->withColumn('UNIX_TIMESTAMP(inserted)', 'insertedTimestamp')
            ->withColumn("ROUND(AVG(Low))", 'avgLow')
            ->withColumn("ROUND(AVG(Mean))", 'avgMean')
            ->withColumn("ROUND(AVG(Median))", 'avgMedian')
            ->withColumn("ROUND(AVG(Count))", 'avgCount')
            ->orderBy('insertedDate', 'asc')
            ->groupBy('insertedDate')
            ->groupBy('inserted')
            ->select('insertedDate', 'insertedTimestamp', 'avgLow', 'avgMean', 'avgMedian', 'avgCount')
            ->find()
            ->getData();

        $result = array_map(function ($row) {
            return array_merge($row, [
                'avgLow' => intval($row['avgLow']),
                'avgMean' => intval($row['avgMean']),
                'avgMedian' => intval($row['avgMedian']),
                'avgCount' => intval($row['avgCount']),
            ]);
        }, $result);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}