<?php declare(strict_types=1);

namespace App\Controller\V1\Devtracker;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;
use App\Schema\Crawl\Devtracker\DevtrackerQuery;

class Postlist extends BaseController
{
    /**
     * @var \JBBCode\Parser
     */
    private $jbb_parser;
    
    /**
     * @param \App\Helpers\RequestHelper $requestHelper
     * @param \JBBCode\Parser $jbb_parser
     *
     * @return void
     */
    public function __construct(\App\Helpers\RequestHelper $requestHelper, \JBBCode\Parser $jbb_parser)
    {
        parent::__construct($requestHelper);
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

        $posts = DevtrackerQuery::create()
            ->withColumn('UNIX_TIMESTAMP(date)', 'timestamp')
            ->_if($data_ary['dev'] !== "")
                ->condition('dev_name', 'Devtracker.DevName = ?', $data_ary['dev'])
                ->condition('dev_id', 'Devtracker.DevId = ?', $data_ary['dev'])
                ->where(array('dev_name', 'dev_id'), 'or')
            ->_endif()
            ->_if($data_ary['discussion_id'] !== 0)
                ->filterByDiscussionId($data_ary['discussion_id'])
            ->_endif()
            ->_if($data_ary['search_term'] !== '')
                ->condition('discussion_name', 'Devtracker.DiscussionName LIKE ?', '%'.$data_ary['search_term'].'%')
                ->condition('body', 'Devtracker.Body LIKE ?', '%'.$data_ary['search_term'].'%')
                ->where(array('dev_name', 'dev_id'), 'or')
            ->_endif()
            ->orderByDate('desc')
            ->limit($data_ary['count'])
            ->offset($data_ary['start_page']*$data_ary['count'])
            ->select(array('dev_name', 'dev_id', 'discussion_id', 'comment_id', 'discussion_name', 'body', 'timestamp'))
            ->find()
            ->getData();

        array_walk($posts, function (&$post) {
            $post['discussion_id'] = (int) $post['discussion_id'];
            $post['discussion_name'] = html_entity_decode($post['discussion_name']);
            $post['timestamp'] = (int) $post['timestamp'];

            // replace some stuff that can lead to trouble
            $post['body'] = preg_replace("/\[quote=.*\].*\[\/quote\]\s+/mis", "", $post['body']);
            $post['body'] = preg_replace("/\<blockquote.*>.*\<\/blockquote>\s+/mis", "", $post['body']);
            $post['body'] = preg_replace("/\[url=\"(.*)\"\](.*)\[\/url\]/misU", "[url=\\1]\\2[/url]", $post['body']);
            // $row['body'] = strip_tags($row['body']);
            $post['body'] = preg_replace('/<[^>]*>/', '', $post['body']);
            $post['body'] = preg_replace('/\\r\\n/', '<br />', $post['body']);

            // // parse JBBCode
            $this->jbb_parser->parse($post['body']);
            $post['body'] = $this->jbb_parser->getAsText();
        });

        // return as JSON
        $payload = json_encode($posts);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json')
          ->withHeader('charset', 'utf-8');
    }
}
