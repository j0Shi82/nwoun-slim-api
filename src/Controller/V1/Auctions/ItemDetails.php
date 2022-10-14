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
            'server' => $this->requestHelper->variable('server', '')
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
            ->withColumn("DATE_FORMAT(inserted, '%Y-%m-%d')", 'InsertedDate')
            ->withColumn('UNIX_TIMESTAMP(inserted)', 'InsertedTimestamp')
            ->withColumn("ROUND(AVG(Low))", 'AvgLow')
            ->withColumn("ROUND(AVG(Mean))", 'AvgMean')
            ->withColumn("ROUND(AVG(Median))", 'AvgMedian')
            ->withColumn("ROUND(AVG(Count))", 'AvgCount')
            ->orderBy('InsertedDate', 'asc')
            ->groupBy('InsertedDate')
            ->select('InsertedDate', 'InsertedTimestamp', 'AvgLow', 'AvgMean', 'AvgMedian', 'AvgCount')
            ->find()
            ->getData();

        $result = array_map(function ($row) {
            return array_merge($row, [
                'AvgLow' => intval($row['AvgLow']),
                'AvgMean' => intval($row['AvgMean']),
                'AvgMedian' => intval($row['AvgMedian']),
                'AvgCount' => intval($row['AvgCount']),
            ]);
        }, $result);

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
