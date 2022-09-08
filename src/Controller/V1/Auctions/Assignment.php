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
        $result = AuctionItemsQuery::create()
            ->filterByServer('GLOBAL')
            ->filterByAllowAuto(true)
            ->filterByLockedDate(array('max' => new \DateTime("now", new \DateTimeZone("UTC"))))
            ->orderByUpdateDate('asc')
            ->findOne();

        $result->setLockedDate(date_add(new \DateTime("now", new \DateTimeZone("UTC")), new \DateInterval("PT1M")));
        $result->save();

        $result = $result->toArray();
        $result['ItemName'] = $result['SearchTerm'];
                  
        $response->getBody()->write(
            str_replace("\/", "/", json_encode($result)));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
