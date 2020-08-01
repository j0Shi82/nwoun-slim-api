<?php declare(strict_types=1);

namespace App\Controller\V1;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Neverwinterfeeds extends BaseController
{
    /**
     * @param \App\Helpers\RequestHelper $requestHelper
     */
    public function __construct(\App\Helpers\RequestHelper $requestHelper, \Feed $feed)
    {
        parent::__construct($requestHelper);
    }

    public function get_pc(Request $request, Response $response)
    {
        $this->attachRequestToRequestHelper($request);

        // define all possible GET data
        $data_ary = array(
            'threshold' => $this->requestHelper->variable('threshold', 2),
        );
        
        $response->getBody()->write(json_encode($data_ary));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
