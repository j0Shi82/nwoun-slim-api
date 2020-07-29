<?php declare(strict_types=1);

namespace App\Controller\V1\Devtracker;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;

class Topiclist extends BaseController
{
    /**
     * @var \App\Services\DB
     */
    private $db;

    public function __construct(\App\Services\DB $db, \App\Helpers\RequestHelper $requestHelper)
    {
        parent::__construct($requestHelper);
        $this->db = $db;
    }

    public function get(Request $request, Response $response)
    {
        $this->attachRequestToRequestHelper($request);

        // define all possible GET data
        $data_ary = array(
            'threshold' => $this->requestHelper->variable('threshold', 2),
        );
        
        $sql = 'SELECT COUNT(*) as post_count, discussion_id, discussion_name, MAX(UNIX_TIMESTAMP(t.date)) as last_active FROM nwoun_devtracker as t GROUP BY discussion_id HAVING post_count >= ' . $data_ary['threshold'] . ' ORDER BY MAX(UNIX_TIMESTAMP(t.date)) DESC';

        $response->getBody()->write(json_encode($this->db->sql_fetch_array($sql)));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
    }
}
