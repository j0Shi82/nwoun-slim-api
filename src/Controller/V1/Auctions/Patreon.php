<?php declare(strict_types=1);

namespace App\Controller\V1\Auctions;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Patreon\API;
use Patreon\OAuth;

class Patreon extends BaseController
{
    public function get(Request $request, Response $response)
    {
        $client_id = "jBcjaRt36vMF6c6rgD6i_qY4OjEi9r9OokZJxEfEolw2BBEHs_nUzqOfV5wCW3K9";      // Replace with your data
        $client_secret = "QatebjNuvuSeevfXr2h7kJkjV5swBabY2acmaHEPcg59Fw6mPOzj2Ow_j-2uG3Wr";  // Replace with your data
        // $redirect_uri = null;   // Replace with your data

        $oauth_client = new OAuth($client_id, $client_secret);
        // $tokens = $oauth_client->get_tokens($_GET['code'], $redirect_uri);
        // $access_token = $tokens['access_token'];
        // $refresh_token = $tokens['refresh_token'];
        $access_token = "-j2URDMU5bm4LT35BK7wJOoRE-wdWLjZTt4jx6RNEis";

        $api_client = new API($access_token);
        $patron_response = $api_client->fetch_user();
        // $patron = $patron_response->get('data');
        // $pledge = null;
        // if ($patron->has('relationships.pledges')) {
            // $pledge = $patron->relationship('pledges')->get(0)->resolve($patron_response);
        // }

        $response->getBody()->write(json_encode('hi'));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
