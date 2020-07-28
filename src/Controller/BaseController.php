<?php declare(strict_types=1);

namespace App\Controller;

class BaseController
{
    
    /**
     * @var \App\Helpers\RequestHelper
     */
    protected $requestHelper;

    /**
     * @param \App\Helpers\RequestHelper $requestHelper
     *
     * @return void
     */
    public function __construct(\App\Helpers\RequestHelper $requestHelper)
    {
        $this->requestHelper = $requestHelper;
    }

    /**
     * Pass request down to the requestHelper
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return void
     */
    protected function attachRequestToRequestHelper(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $this->requestHelper->attachRequest($request);
    }
}
