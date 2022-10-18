<?php

declare(strict_types=1);

namespace App\Controller\V1\Devtracker;

use App\Controller\BaseController;

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
    public function get_cats(Request $request, Response $response)
    {
        // https://forum.arcgames.com/neverwinter/categories.json
        // this was pulled manually, maybe add to crawler in the future?
        $response->getBody()->write(json_encode([
            [ 'id' => 597, 'title' => 'Neverwinter', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinter" ],
            [ 'id' => 505, 'title' => 'News & Announcements', 'url' => "https://forum.arcgames.com/neverwinter/categories/news-announcements-pc" ],
            [ 'id' => 1126, 'title' => 'Collaborative Development Program (CDP)', 'url' => "https://forum.arcgames.com/neverwinter/categories/collaborative-development-program" ],
            [ 'id' => 570, 'title' => 'Neverwinter Discussion (Xbox One)', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinter-discussion-xbox-one" ],
            [ 'id' => 571, 'title' => 'General Discussion (Xbox One)', 'url' => "https://forum.arcgames.com/neverwinter/categories/general-discussion-xbox-one" ],
            [ 'id' => 589, 'title' => 'Patch Notes (Xbox One)', 'url' => "https://forum.arcgames.com/neverwinter/categories/patch-notes-xbox-one" ],
            [ 'id' => 572, 'title' => 'Player Feedback (Xbox One)', 'url' => "https://forum.arcgames.com/neverwinter/categories/player-feedback-xbox-one" ],
            [ 'id' => 573, 'title' => 'Bug Reports (Xbox One)', 'url' => "https://forum.arcgames.com/neverwinter/categories/bug-reports-xbox-one" ],
            [ 'id' => 574, 'title' => 'Guild & Alliance Recruitment (Xbox One)', 'url' => "https://forum.arcgames.com/neverwinter/categories/guild-recruitment-xbox-one" ],
            [ 'id' => 586, 'title' => 'Groups & Adventures (Xbox One)', 'url' => "https://forum.arcgames.com/neverwinter/categories/groups-adventures-xbox-one" ],
            [ 'id' => 595, 'title' => 'The Moonstone Mask (Xbox One)', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-moonstone-mask-xbox-one" ],
            [ 'id' => 504, 'title' => 'Neverwinter Discussion (PC)', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinter-discussion-pc" ],
            [ 'id' => 507, 'title' => 'General Discussion (PC)', 'url' => "https://forum.arcgames.com/neverwinter/categories/general-discussion-pc" ],
            [ 'id' => 556, 'title' => 'Patch Notes (PC)', 'url' => "https://forum.arcgames.com/neverwinter/categories/patch-notes-pc" ],
            [ 'id' => 587, 'title' => 'Player Feedback (PC)', 'url' => "https://forum.arcgames.com/neverwinter/categories/player-feedback-pc" ],
            [ 'id' => 533, 'title' => 'Bug Reports (PC)', 'url' => "https://forum.arcgames.com/neverwinter/categories/bug-reports-pc" ],
            [ 'id' => 510, 'title' => 'Guild & Alliance Recruitment (PC)', 'url' => "https://forum.arcgames.com/neverwinter/categories/guild-recruitment-pc" ],
            [ 'id' => 509, 'title' => 'The Moonstone Mask (PC)', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-moonstone-mask-pc" ],
            [ 'id' => 557, 'title' => 'The Foundry (PC)', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-foundry" ],
            [ 'id' => 560, 'title' => 'Foundry Quest Database', 'url' => "https://forum.arcgames.com/neverwinter/categories/foundry-quest-database" ],
            [ 'id' => 567, 'title' => 'Foundry Mechanics & Questions', 'url' => "https://forum.arcgames.com/neverwinter/categories/foundry-mechanics-questions" ],
            [ 'id' => 1112, 'title' => 'Neverwinter Discussion (PlayStation\u00ae4)', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinter-discussion-playstation-4" ],
            [ 'id' => 1114, 'title' => 'General Discussion (PlayStation\u00ae4)', 'url' => "https://forum.arcgames.com/neverwinter/categories/general-discussion-%28playstation%C2%AE4%29" ],
            [ 'id' => 1121, 'title' => 'Patch Notes (PlayStation\u00ae4)', 'url' => "https://forum.arcgames.com/neverwinter/categories/patch-notes-%28playstation%C2%AE4%29" ],
            [ 'id' => 1117, 'title' => 'Player Feedback (PlayStation\u00ae4)', 'url' => "https://forum.arcgames.com/neverwinter/categories/player-feedback-%28playstation%C2%AE4%29" ],
            [ 'id' => 1118, 'title' => 'Bug Reports (PlayStation\u00ae4)', 'url' => "https://forum.arcgames.com/neverwinter/categories/bug-reports-%28playstation4%29" ],
            [ 'id' => 1115, 'title' => 'Guild & Alliance Recruitment (PlayStation\u00ae4)', 'url' => "https://forum.arcgames.com/neverwinter/categories/guild-alliance-recruitment-%28playstation%C2%AE4%29" ],
            [ 'id' => 1116, 'title' => 'The Moonstone Mask (PlayStation\u00ae4)', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-moonstone-mask-%28playstation%C2%AE4%29" ],
            [ 'id' => 531, 'title' => 'PvE Discussion', 'url' => "https://forum.arcgames.com/neverwinter/categories/pve-discussion-pc" ],
            [ 'id' => 585, 'title' => 'PvP Discussion', 'url' => "https://forum.arcgames.com/neverwinter/categories/pvp-discussion-pc" ],
            [ 'id' => 513, 'title' => 'Class Forums', 'url' => "https://forum.arcgames.com/neverwinter/categories/class-forums-pc" ],
            [ 'id' => 1131, 'title' => 'The Tavern', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-tavern" ],
            [ 'id' => 484, 'title' => 'The Militia Barracks', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-militia-barracks" ],
            [ 'id' => 596, 'title' => 'The Guard Barracks', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-guard-barracks" ],
            [ 'id' => 499, 'title' => 'The Library', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-library" ],
            [ 'id' => 496, 'title' => 'The Temple', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-temple" ],
            [ 'id' => 497, 'title' => 'The Thieves\' Den', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-thieves-den" ],
            [ 'id' => 568, 'title' => 'The Wilds', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-wilds" ],
            [ 'id' => 569, 'title' => 'The Nine Hells', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-nine-hells" ],
            [ 'id' => 588, 'title' => 'The Citadel', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-citadel" ],
            [ 'id' => 1122, 'title' => 'Guides', 'url' => "https://forum.arcgames.com/neverwinter/categories/guides" ],
            [ 'id' => 508, 'title' => 'Player Corner', 'url' => "https://forum.arcgames.com/neverwinter/categories/player-corner" ],
            [ 'id' => 511, 'title' => 'Art and Fiction', 'url' => "https://forum.arcgames.com/neverwinter/categories/art-and-fiction" ],
            [ 'id' => 526, 'title' => 'Off Topic', 'url' => "https://forum.arcgames.com/neverwinter/categories/off-topic3" ],
            [ 'id' => 1095, 'title' => 'The Lower Depths of Neverwinter', 'url' => "https://forum.arcgames.com/neverwinter/categories/the-lower-depths" ],
            [ 'id' => 558, 'title' => 'Neverwinter Game Support', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinter-game-support" ],
            [ 'id' => 559, 'title' => 'Peer to Peer Tech Forum', 'url' => "https://forum.arcgames.com/neverwinter/categories/technical-support2" ],
            [ 'id' => 561, 'title' => 'NeverwinterPreview Shard (PC)', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinterpreview-shard-pc" ],
            [ 'id' => 562, 'title' => 'NeverwinterPreview - Announcements/Release Notes', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinterpreview-announcements-release-notes" ],
            [ 'id' => 563, 'title' => 'NeverwinterPreview - Bug Reports', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinterpreview-bug-reports" ],
            [ 'id' => 564, 'title' => 'NeverwinterPreview - Feedback/General Discussion', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinterpreview-feedback-general-discussion" ],
            [ 'id' => 565, 'title' => 'NeverwinterPreview - The Foundry', 'url' => "https://forum.arcgames.com/neverwinter/categories/neverwinterpreview-the-foundry" ],
            [ 'id' => 5555, 'title' => 'Neverwinter Subreddit', 'url' => "https://www.reddit.com/r/Neverwinter/" ],
        ]));
        return $response
          ->withHeader('Content-Type', 'application/json')
          ->withHeader('charset', 'utf-8');
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
            'discussion_id' => $this->requestHelper->variable('discussion_id', '0'),
            'search_term' => $this->requestHelper->variable('search_term', ''),
            'count' => $this->requestHelper->variable('count', 20),
            'page' => $this->requestHelper->variable('page', 1)
        );

        // run checks on data
        if ($data_ary['count'] > 50) {
            $data_ary['count'] = 50;
        }
        if ($data_ary['count'] < 20) {
            $data_ary['count'] = 20;
        }
        if ($data_ary['page'] < 1) {
            $data_ary['page'] = 1;
        }

        $posts = DevtrackerQuery::create()
            ->withColumn('UNIX_TIMESTAMP(date)', 'timestamp')
            ->_if($data_ary['dev'] !== "")
                ->condition('dev_name', 'Devtracker.DevName LIKE ?', $data_ary['dev'])
                ->condition('dev_id', 'Devtracker.DevId LIKE ?', $data_ary['dev'])
                ->where(array('dev_name', 'dev_id'), 'or')
            ->_endif()
            ->_if($data_ary['discussion_id'] !== '0')
                ->filterByDiscussionId($data_ary['discussion_id'])
            ->_endif()
            ->_if($data_ary['search_term'] !== '')
                ->condition('discussion_name', 'Devtracker.DiscussionName LIKE ?', '%'.$data_ary['search_term'].'%')
                ->condition('body', 'Devtracker.Body LIKE ?', '%'.$data_ary['search_term'].'%')
                ->where(array('dev_name', 'dev_id'), 'or')
            ->_endif()
            ->orderByDate('desc')
            ->limit($data_ary['count'])
            ->offset(($data_ary['page'] - 1)*$data_ary['count'])
            ->select(array(
                'dev_name',
                'dev_name' => 'devName',
                'dev_id',
                'dev_id' => 'devId',
                'discussion_id',
                'discussion_id' => 'discussionId',
                'comment_id',
                'comment_id' => 'commentId',
                'category_id',
                'category_id' => 'categoryId',
                'discussion_name',
                'discussion_name' => 'discussionName',
                'body',
                'timestamp'
            ))
            ->find()
            ->getData();

        array_walk($posts, function (&$post) {
            $post['discussionName'] = html_entity_decode($post['discussionName']);
            $post['discussion_name'] = $post['discussionName'];
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
