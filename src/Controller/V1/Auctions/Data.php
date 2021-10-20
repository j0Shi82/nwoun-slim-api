<?php declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregates;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery;
use App\Schema\Crawl\AuctionItems\AuctionItems;
use App\Schema\Crawl\AuctionItems\AuctionItemsQuery;
use App\Schema\Crawl\AuctionDetails\AuctionDetails;
use App\Schema\Crawl\AuctionDetails\AuctionDetailsQuery;

class Data extends BaseController
{
    public function __construct(\App\Helpers\RequestHelper $requestHelper)
    {
        parent::__construct($requestHelper);
    }

    public function post(Request $request, Response $response)
    {
        $this->attachRequestToRequestHelper($request);

        $parseBody = $request->getParsedBody();

        if ($parseBody['Count'] === -1) {
            $auctionItem = AuctionItemsQuery::create()->findPk(array($parseBody['ItemDef'], $parseBody['Server']));
            $auctionItem->setUpdateDate(new \DateTime("now", new \DateTimeZone("UTC")));
            $auctionItem->setAllowAuto(false);
            $auctionItem->save();
        } else {
            $lastAuctionAggregate = AuctionAggregatesQuery::create()
                ->filterByItemDef($parseBody['ItemDef'])
                ->filterByServer($parseBody['Server'])
                ->orderByInserted('desc')
                ->findOne();

            $now = new \DateTime("now", new \DateTimeZone("UTC"));
            $now->sub(new \DateInterval("PT1H"));

            if ($lastAuctionAggregate === null || $lastAuctionAggregate->getInserted() < $now) {
                $newAuctionAggregate = new AuctionAggregates();
                $newAuctionAggregate->setItemDef($parseBody['ItemDef']);
                $newAuctionAggregate->setServer($parseBody['Server']);
                $newAuctionAggregate->setLow($parseBody['Low']);
                $newAuctionAggregate->setMean($parseBody['Mean']);
                $newAuctionAggregate->setMedian($parseBody['Median']);
                $newAuctionAggregate->setCount($parseBody['Count']);
                $newAuctionAggregate->setInserted(new \DateTime("now", new \DateTimeZone("UTC")));
                $newAuctionAggregate->save();
            }

            array_walk($parseBody['Items'], function ($item, $i, $server) {
                if ($item['Price']) {
                    $auctionDetail = AuctionDetailsQuery::create()->findPk(
                        array(
                            $item['InternalName'],
                            $server,
                            explode("@", $item['Seller'])[0],
                            explode("@", $item['Seller'])[1],
                            $item['ExpireTime']
                        )
                    );

                    if ($auctionDetail === null) {
                        $newAuctionDetail = new AuctionDetails();
                        $newAuctionDetail->setItemDef($item['InternalName']);
                        $newAuctionDetail->setServer($server);
                        $newAuctionDetail->setSellerName(explode("@", $item['Seller'])[0]);
                        $newAuctionDetail->setSellerHandle(explode("@", $item['Seller'])[1]);
                        $newAuctionDetail->setExpireTime($item['ExpireTime']);
                        $newAuctionDetail->setPrice($item['Price']);
                        $newAuctionDetail->setCount($item['Count']);
                        $newAuctionDetail->setPricePer($item['Price'] / $item['Count']);
                        $newAuctionDetail->save();
                    }
                }
            }, $parseBody['Server']);

            $auctionItem = AuctionItemsQuery::create()->findPk(array($parseBody['ItemDef'], $parseBody['Server']));
            $auctionItem->setUpdateDate(new \DateTime("now", new \DateTimeZone("UTC")));
            if (count($parseBody['Items'])) {
                $auctionItem->setCategories(json_encode(explode(" ", $parseBody['Items'][0]['Categories'])));
                $auctionItem->setQuality($parseBody['Items'][0]['Quality']);
            }
            $auctionItem->save();
        }

        $response->getBody()->write("");
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
