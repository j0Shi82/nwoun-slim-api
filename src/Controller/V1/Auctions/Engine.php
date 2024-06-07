<?php

declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Schema\Crawl\AuctionItems\AuctionItemsQuery;

class Engine extends BaseController
{
    public function get(Request $request, Response $response)
    {
        $result = AuctionItemsQuery::create()
            ->filterByServer('GLOBAL')
            ->filterByAllowAuto(true)
            ->filterByUpdateDate(array('min' => date_sub(new \DateTime("now", new \DateTimeZone("UTC")), new \DateInterval("P1D"))))
            ->withColumn("IF(SUM(IF(update_date >= (UTC_TIMESTAMP - INTERVAL 15 MINUTE), 1, 0)) > 0, true, false)", 'isActive')
            ->withColumn("(COUNT(*) / 2) / (UNIX_TIMESTAMP(UTC_TIMESTAMP) - UNIX_TIMESTAMP(MIN(update_date))) * 60 * 60 * 24", 'itemsPerDay')
            ->select(array('isActive', 'itemsPerDay'))
            ->findOne();

        $result2 = AuctionItemsQuery::create()
            ->filterByServer('GLOBAL')
            ->filterByAllowAuto(true)
            ->withColumn("COUNT(*)", 'Count')
            ->select(array('Count'))
            ->findOne();

        $response->getBody()->write(json_encode(array_merge($result, ['totalItems' => $result2])));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
