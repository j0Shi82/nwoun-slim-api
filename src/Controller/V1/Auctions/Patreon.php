<?php

declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Patreon\API;

class Patreon extends BaseController
{
    public function get(Request $request, Response $response)
    {
        $api_client = new API($_ENV['PATREON_ACCESS_TOKEN']);
        $patron_campaign_response = $api_client->get_data("campaigns/9239090?include=tiers&&fields%5Btier%5D=amount_cents,description,title");
        $patron_member_response = $api_client->get_data("campaigns/9239090/members?include=currently_entitled_tiers&fields%5Bmember%5D=full_name,is_follower,last_charge_date,last_charge_status,lifetime_support_cents,currently_entitled_amount_cents,patron_status&fields%5Btier%5D=title");

        $tier_map = array_map(function ($tier) use ($patron_member_response) {
            return [
                'title' => $tier['attributes']['title'],
                'members' => array_map(function ($member) {
                    return [
                        'name' => $member['attributes']['full_name']
                    ];
                }, array_filter($patron_member_response['data'], function ($member) use ($tier) {
                    return $member['relationships']['currently_entitled_tiers']['data'][0]['id'] == $tier['id'];
                })),
            ];
        }, $patron_campaign_response['included']);

        $response->getBody()->write(json_encode($tier_map));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
