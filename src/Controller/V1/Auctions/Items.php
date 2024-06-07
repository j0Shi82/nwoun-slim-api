<?php

declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Items extends BaseController
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

        // define all possible GET data
        $data_ary = array(
            'startDate' => $this->requestHelper->variable('start', '1970-01-01'),
            'endDate' => $this->requestHelper->variable('end', '2070-01-01'),
        );

        // $result = array_map(
        //     function ($row) {
        //         return array_merge($row, [
        //             'categories' => json_decode($row['categories'])
        //         ]);
        //     },
        //     AuctionItemsQuery::create()
        //         ->joinAuctionAggregates()
        //         ->withColumn('AuctionAggregates.Count', 'count')
        //         ->withColumn('AuctionAggregates.Low', 'low')
        //         ->withColumn('AuctionAggregates.Mean', 'mean')
        //         ->withColumn('UNIX_TIMESTAMP(AuctionAggregates.Inserted)', 'inserted')
        //         ->select(['item_def' => 'itemDef', 'quality', 'item_name' => 'itemName', 'categories'])
        //         ->where("AuctionAggregates.Inserted = (
        //         SELECT MAX(inserted) 
        //         FROM auction_aggregates 
        //         WHERE 
        //             server = auction_items.server 
        //             AND count > 0 
        //             AND item_def = auction_items.item_def 
        //             AND inserted >= '" . $data_ary['startDate'] . "' 
        //             AND inserted <= '" . $data_ary['endDate'] . "'
        //     )")
        //         ->orderBy('AuctionItems.ItemName', 'asc')
        //         ->find()
        //         ->toArray()
        // );

        $results = $this->db->sql_fetch_array("
            SELECT 
                auction_items.item_def as itemDef, 
                auction_items.quality,
                auction_items.item_name as itemName,
                auction_items.categories,
                auction_aggregates.low,
                auction_aggregates.mean,
                auction_aggregates.count,
                UNIX_TIMESTAMP(auction_aggregates.inserted) as inserted
            FROM (
                SELECT MAX(aggr1.id) as id, aggr1.item_def, aggr1.server 
                FROM auction_aggregates as aggr1 
                INNER JOIN auction_aggregates as aggr2 ON aggr1.id = aggr2.id
                WHERE
                    aggr1.count > 0 
                    AND aggr1.inserted >= '1970-01-01' 
                    AND aggr1.inserted <= '2070-01-01' 
                GROUP BY aggr1.item_def, aggr1.server
            ) as aggr_newest, 
            auction_aggregates, 
            auction_items 
            WHERE 
                aggr_newest.id = auction_aggregates.id 
                AND auction_items.server = auction_aggregates.server 
                AND auction_items.item_def = auction_aggregates.item_def 
            ORDER BY auction_items.item_name ASC
        ");

        $result = array_map(
            function ($row) {
                return array_merge($row, [
                    'categories' => json_decode($row['categories'])
                ]);
            },
            $results
        );

        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}