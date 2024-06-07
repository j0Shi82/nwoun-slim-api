<?php

declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregates;
use App\Schema\Crawl\AuctionAggregates\AuctionAggregatesQuery;
use App\Schema\Crawl\AuctionItems\AuctionItemsQuery;

class Data extends BaseController
{
    public function post(Request $request, Response $response)
    {
        $parseBody = $request->getParsedBody();

        // check for item in crawl database
        if ($parseBody['ItemDef'] !== 'NWOUN_INTERNAL_SENDAUCTIONS') {
            $checkItem = AuctionItemsQuery::create()->findPk(array($parseBody['ItemDef'], $parseBody['Server']));
            if ($checkItem === null) {
                $response->getBody()->write("err: item");
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->withHeader('charset', 'utf-8');
            }
        } else {
            // import auctions as new crawl items
            // use custom sql to bulk insert new auctions
            // much faster than using propel objects and queries
            $con = \Propel\Runtime\Propel::getWriteConnection('crawl');
            $itemInserts = [];
            $itemNames = [];

            foreach ($parseBody['Items'] as $item) {
                if (!in_array($item['InternalName'], $itemNames)) {
                    $itemInserts[] = "
                        (
                            \"" . $item['InternalName'] . "\",
                            \"" . str_replace('"', '\"', $item['DisplayName']) . "\",
                            \"" . $item['Quality'] . "\",
                            '" . json_encode(explode(" ", $item['Categories'])) . "',
                            NULL,
                            0,
                            \"" . ($parseBody['Server'] ? $parseBody['Server'] : 'GLOBAL') . "\",
                            NOW()
                        )
                    ";
                    $itemNames[] = $item['InternalName'];
                }
            }
            ;

            if (count($itemInserts)) {
                $stmt = $con->prepare("INSERT IGNORE INTO auction_items (item_def, item_name, quality, categories, crawl_category, allow_auto, server, update_date) VALUES " . implode(",", $itemInserts));
                $stmt->execute();
            }

            $response->getBody()->write(json_encode($itemNames));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('charset', 'utf-8');
        }

        if ($parseBody['Count'] === -1) {
            // item can't be crawled automatically
            $auctionItem = AuctionItemsQuery::create()->findPk(array($parseBody['ItemDef'], $parseBody['Server']));
            $auctionItem->setUpdateDate(new \DateTime("now", new \DateTimeZone("UTC")));
            $auctionItem->setAllowAuto(false);
            $auctionItem->save();
        } else {
            // limit aggregates to four per day
            $lastAuctionAggregate = AuctionAggregatesQuery::create()
                ->filterByItemDef($parseBody['ItemDef'])
                ->filterByServer($parseBody['Server'])
                ->orderByInserted('desc')
                ->findOne();

            $now = new \DateTime("now", new \DateTimeZone("UTC"));
            $now->sub(new \DateInterval("PT6H"));

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

            // use custom sql to bulk insert new auctions
            // much faster than using propel objects and queries
            $con = \Propel\Runtime\Propel::getWriteConnection('crawl');
            $auctionInserts = [];

            foreach ($parseBody['Items'] as $item) {
                if ($item['Price']) {
                    $auctionInserts[] = "
                        (
                            \"" . $item['InternalName'] . "\",
                            \"" . $parseBody['Server'] . "\",
                            \"" . explode("@", $item['Seller'])[0] . "\",
                            \"" . explode("@", $item['Seller'])[1] . "\",
                            " . $item['ExpireTime'] . ",
                            " . $item['Price'] . ",
                            " . $item['Count'] . ",
                            " . ($item['Price'] / $item['Count']) . "
                        )
                    ";
                }
            }
            ;

            if (count($auctionInserts)) {
                $stmt = $con->prepare("INSERT IGNORE INTO auction_details (item_def, server, seller_name, seller_handle, expire_time, price, count, price_per) VALUES " . implode(",", $auctionInserts));
                $stmt->execute();
            }

            $auctionItem = AuctionItemsQuery::create()->findPk(array($parseBody['ItemDef'], $parseBody['Server']));
            $auctionItem->setUpdateDate(new \DateTime("now", new \DateTimeZone("UTC")));
            $auctionItem->setLockedDate(new \DateTime("now", new \DateTimeZone("UTC")));
            if (count($parseBody['Items'])) {
                $auctionItem->setCategories(json_encode(explode(" ", $parseBody['Items'][0]['Categories'])));
                $auctionItem->setQuality($parseBody['Items'][0]['Quality']);
            }
            $auctionItem->save();
        }

        $response->getBody()->write("done");
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
