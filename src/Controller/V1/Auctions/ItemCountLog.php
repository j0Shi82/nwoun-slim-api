<?php

declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLog;
use App\Schema\Crawl\AuctionCrawlLog\AuctionCrawlLogQuery;

class ItemCountLog extends BaseController
{
    public function post(Request $request, Response $response)
    {
        $parseBody = $request->getParsedBody();

        if (empty($parseBody['ItemDef']) || empty($parseBody['AccountName']) || empty($parseBody['CharacterName']) || !is_numeric($parseBody['Count'])) {
            $response->getBody()->write(json_encode([
                'status' => 400,
                'status_msg' => 'not all params provided'
            ]));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withHeader('charset', 'utf-8')
                ->withStatus(400);
        }

        // check for item in db
        $logItem = AuctionCrawlLogQuery::create()->findPk(array($parseBody['ItemDef'], $parseBody['CharacterName'], $parseBody['AccountName']));
        if ($logItem === null) {
            $logItem = new AuctionCrawlLog();
            $logItem->setItemDef($parseBody['ItemDef']);
            $logItem->setAccountName($parseBody['AccountName']);
            $logItem->setCharacterName($parseBody['CharacterName']);
            $logItem->setItemCount($parseBody['Count']);
        } else {
            $logItem->setItemCount($parseBody['Count']);
        }

        $logItem->save();

        $response->getBody()->write("done");
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
