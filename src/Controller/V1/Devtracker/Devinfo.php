<?php declare(strict_types=1);

namespace App\Controller\V1\Devtracker;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;

class Devinfo extends BaseController
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
            'dev' => $this->requestHelper->variable('dev', ''),
        );

        $ch = \curl_init();
        // Will return the response, if false it print the response
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        \curl_setopt($ch, CURLOPT_URL, "https://forum.arcgames.com/neverwinter/api/v1/users/get.json?User.ID=".$data_ary['dev']);
        \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Execute
        $payload=\curl_exec($ch);
        // Closing
        \curl_close($ch);

        $response->getBody()->write(json_encode(json_decode($payload)));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
