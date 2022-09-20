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
            'id' => $this->requestHelper->variable('id', 0),
        );

        $ch = \curl_init();
        // Will return the response, if false it print the response
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        if ($data_ary['id']) {
            \curl_setopt($ch, CURLOPT_URL, "https://forum.arcgames.com/neverwinter/api/v1/users/get.json?User.ID=".$data_ary['id']);
        } else {
            \curl_setopt($ch, CURLOPT_URL, "https://www.reddit.com/user/".$data_ary['dev']."/about.json");
        }

        \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // Execute
        $payload=\curl_exec($ch);
        // Closing
        \curl_close($ch);

        $payload = json_decode($payload);

        $return = [
            'img' => $payload->Profile->PhotoUrl ?? explode('?', $payload->data->icon_img)[0],
        ];

        $response->getBody()->write(json_encode($return));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
