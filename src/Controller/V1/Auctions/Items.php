<?php declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;
use App\Schema\Crawl\AuctionItems\AuctionItemsQuery;

class Items extends BaseController
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
            'startDate' => $this->requestHelper->variable('start', '1970-01-01'),
            'endDate' => $this->requestHelper->variable('end', '2070-01-01'),
        );
        
        $result = AuctionItemsQuery::create()
            ->joinAuctionAggregates()
            ->withColumn('AuctionAggregates.Count', 'Count')
            ->withColumn('AuctionAggregates.Low', 'Low')
            ->withColumn('AuctionAggregates.Mean', 'Mean')
            ->withColumn('UNIX_TIMESTAMP(AuctionAggregates.Inserted)', 'Inserted')
            ->where("AuctionAggregates.Inserted = (
                SELECT MAX(inserted) 
                FROM auction_aggregates 
                WHERE 
                    server = auction_items.server 
                    AND count > 0 
                    AND item_def = auction_items.item_def 
                    AND inserted >= '" . $data_ary['startDate'] . "' 
                    AND inserted <= '" . $data_ary['endDate'] . "'
            )")
            ->orderBy('AuctionItems.ItemName', 'asc')
            ->find();

        $response->getBody()->write(json_encode($result->toArray()));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
