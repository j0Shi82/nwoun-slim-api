<?php declare(strict_types=1);

namespace App\Controller;

class BaseController
{
    protected \App\Helpers\RequestHelper $requestHelper;

    public function __construct(\App\Helpers\RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    protected function attachRequestToRequestHelper(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $this->requestHelper->attachRequest($request);
    }
}
