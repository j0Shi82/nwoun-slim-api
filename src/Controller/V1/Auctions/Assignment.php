<?php declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;
use App\Schema\Crawl\AuctionItems\AuctionItemsQuery;

class Assignment extends BaseController
{
    public function get(Request $request, Response $response)
    {
        $result = AuctionItemsQuery::create()->filterByServer('GLOBAL')->filterByAllowAuto(true)->orderByUpdateDate('asc')->findOne();

        $response->getBody()->write(json_encode($result->toArray()));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
