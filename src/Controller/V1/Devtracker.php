<?php declare(strict_types=1);

namespace App\Controller\V1;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;

class Devtracker extends BaseController
{
    private \App\Services\DB $db;
    private \JBBCode\Parser $jbb_parser;

    public function __construct(\App\Services\DB $db, \App\Helpers\RequestHelper $requestHelper, \JBBCode\Parser $jbb_parser)
    {
        parent::__construct($requestHelper);
        $this->db = $db;
        $this->jbb_parser = $jbb_parser;
    }

    public function get(Request $request, Response $response)
    {
        $this->attachRequestToRequestHelper($request);

        // grab possible GET data
        $data_ary = array(
            'dev' => $this->requestHelper->variable('dev', ''),
            'discussion_id' => $this->requestHelper->variable('discussion_id', 0),
            'search_term' => $this->requestHelper->variable('search_term', ''),
            'count' => $this->requestHelper->variable('count', 20),
            'start_page' => $this->requestHelper->variable('start_page', 0),
            'callback' => $this->requestHelper->variable('callback', ''),
        );

        // run checks
        if ($data_ary['count'] > 50) {
            $data_ary['count'] = 50;
        }
        if ($data_ary['count'] < 20) {
            $data_ary['count'] = 20;
        }
        if ($data_ary['start_page'] < 0) {
            $data_ary['start_page'] = 0;
        }

        /* get tracker from db */
        $sql = '
            SELECT
                t.dev_name, t.discussion_id, t.discussion_name, t.body, UNIX_TIMESTAMP(t.date) as timestamp
            FROM 
                nwoun_devtracker as t
            WHERE
                (
                    t.dev_name = \''.$data_ary['dev'].'\' 
                        OR 
                    t.dev_id = \''.$data_ary['dev'].'\' 
                        OR 
                    \''.$data_ary['dev'].'\' = \'\'
                )
                    AND
                (
                    discussion_id = '.$data_ary['discussion_id'].' 
                        OR 
                    '.$data_ary['discussion_id'].' = 0
                )
                    AND
                (
                    discussion_name LIKE \'%'.$data_ary['search_term'].'%\' 
                        OR 
                    body LIKE \'%'.$data_ary['search_term'].'%\'
                )
            ORDER BY
                t.date DESC
            LIMIT 
                '.($data_ary['start_page']*$data_ary['count']).','.$data_ary['count'].'
        ';
        
        $result = $this->db->connection->query($sql);

        $this->jbb_parser->addCodeDefinitionSet(new DefaultCodeDefinitionSet());
    
        $tracker_ary = array();
        while ($row = $result->fetch_array()) {
            $row['discussion_id'] = (int) $row['discussion_id'];
            $row['timestamp'] = (int) $row['timestamp'];
            $row['body'] = preg_replace("/\[quote=.*\].*\[\/quote\]\s+/mis", "", $row['body']);
            $row['body'] = preg_replace("/\<blockquote.*>.*\<\/blockquote>\s+/mis", "", $row['body']);
            $row['body'] = preg_replace("/\[url=\"(.*)\"\](.*)\[\/url\]/misU", "[url=\\1]\\2[/url]", $row['body']);
            $row['body'] = strip_tags($row['body']);
            //$row['body'] = nl2br($row['body']);
            //$row['body'] = str_replace(array("\r\n", "\r", "\n"), '', $row['body']);
            $this->jbb_parser->parse($row['body']);
            $row['body'] = $this->jbb_parser->getAsText();
            $tracker_ary[] = $row;
        }

        $payload = json_encode($tracker_ary);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json')
          ->withHeader('charset', 'utf-8');
    }
}
