<?php declare(strict_types=1);

namespace App\Controller\V1\Devtracker;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;

class Postlist extends BaseController
{
    /**
     * @var \App\Services\DB
     */
    private $db;

    /**
     * @var \JBBCode\Parser
     */
    private $jbb_parser;
    
    /**
     * @param \App\Services\DB $db
     * @param \App\Helpers\RequestHelper $requestHelper
     * @param \JBBCode\Parser $jbb_parser
     *
     * @return void
     */
    public function __construct(\App\Services\DB $db, \App\Helpers\RequestHelper $requestHelper, \JBBCode\Parser $jbb_parser)
    {
        parent::__construct($requestHelper);
        $this->db = $db;
        $this->jbb_parser = $jbb_parser;
        $this->jbb_parser->addCodeDefinitionSet(new DefaultCodeDefinitionSet());
    }
    
    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function get(Request $request, Response $response)
    {
        $this->attachRequestToRequestHelper($request);

        // define all possible GET data
        $data_ary = array(
            'dev' => $this->requestHelper->variable('dev', ''),
            'discussion_id' => $this->requestHelper->variable('discussion_id', 0),
            'search_term' => $this->requestHelper->variable('search_term', ''),
            'count' => $this->requestHelper->variable('count', 20),
            'start_page' => $this->requestHelper->variable('start_page', 0)
        );

        // run checks on data
        if ($data_ary['count'] > 50) {
            $data_ary['count'] = 50;
        }
        if ($data_ary['count'] < 20) {
            $data_ary['count'] = 20;
        }
        if ($data_ary['start_page'] < 0) {
            $data_ary['start_page'] = 0;
        }

        /* build tracker query for db */
        $sql = '
            SELECT
                t.dev_name, t.dev_id, t.discussion_id, t.comment_id, t.discussion_name, t.body, UNIX_TIMESTAMP(t.date) as timestamp
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
        
        // query database
        $result = $this->db->connection->query($sql);

        // populate results array
        $tracker_ary = array();
        while ($row = $result->fetch_array()) {
            $row['discussion_id'] = (int) $row['discussion_id'];
            $row['timestamp'] = (int) $row['timestamp'];

            // replace some stuff that can lead to trouble
            $row['body'] = preg_replace("/\[quote=.*\].*\[\/quote\]\s+/mis", "", $row['body']);
            $row['body'] = preg_replace("/\<blockquote.*>.*\<\/blockquote>\s+/mis", "", $row['body']);
            $row['body'] = preg_replace("/\[url=\"(.*)\"\](.*)\[\/url\]/misU", "[url=\\1]\\2[/url]", $row['body']);
            // $row['body'] = strip_tags($row['body']);

            // // parse JBBCode
            $this->jbb_parser->parse($row['body']);
            $row['body'] = $this->jbb_parser->getAsText();

            // add to results array
            $tracker_ary[] = $row;
        }

        // return as JSON
        $payload = json_encode($tracker_ary);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json')
          ->withHeader('charset', 'utf-8');
    }
}
