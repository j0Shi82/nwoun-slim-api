<?php

namespace App\Application;

use Slim\Exception\HttpNotFoundException;
use App\Controller\V1\Devtracker\Postlist;
use App\Controller\V1\Devtracker\Devinfo;
use App\Controller\V1\Devtracker\Devlist;
use App\Controller\V1\Devtracker\Topiclist;
use App\Controller\V1\Neverwinterfeeds;
use App\Controller\V1\Infohub\Articles;
use App\Controller\V1\Infohub\Infohub;
use App\Controller\V1\Auctions\Assignment;
use App\Controller\V1\Auctions\Data;
use App\Services\DB;
use App\Middleware\Cors;

class Routes
{
    /**
     * this just defines all the routes we need
     *
     * @param \Slim\App $app
     *
     * @return void
     */
    public static function add(\Slim\App $app)
    {
        $app->group('/v1', function (\Slim\Routing\RouteCollectorProxy $v1Group) {
            Routes::addRoutes($v1Group);
            Routes::add404CatchAll($v1Group);
        })->add(new Cors());
        
        $app->options('/{routes:.+}', function ($request, $response) {
            return $response;
        })->add(new Cors());
        
        Routes::add404CatchAll($app);
    }
    
    /**
     * add devtracker routes
     *
     * @param  \Slim\Routing\RouteCollectorProxy $v1Group
     *
     * @return void
     */
    private static function addRoutes(\Slim\Routing\RouteCollectorProxy $v1Group)
    {
        $v1Group->group('/devtracker', function (\Slim\Routing\RouteCollectorProxy $devtrackerGroup) {
            $devtrackerGroup->get('/list', [Postlist::class, 'get']);
            $devtrackerGroup->get('/devinfo', [Devinfo::class, 'get']);
            $devtrackerGroup->get('/devlist', [Devlist::class, 'get']);
            $devtrackerGroup->get('/topiclist', [Topiclist::class, 'get']);
            Routes::add404CatchAll($devtrackerGroup);
        });

        $v1Group->group('/auctions', function (\Slim\Routing\RouteCollectorProxy $auctionsGroup) {
            $auctionsGroup->get('/assignment', [Assignment::class, 'get']);
            $auctionsGroup->post('/data', [Data::class, 'post']);
            Routes::add404CatchAll($auctionsGroup);
        });

        $v1Group->group('/nwfeeds', function (\Slim\Routing\RouteCollectorProxy $nwfeedsGroup) {
            $nwfeedsGroup->get('/arcgamespc', [Neverwinterfeeds::class, 'get_pc']);
            $nwfeedsGroup->get('/arcgamesxbox', [Neverwinterfeeds::class, 'get_xbox']);
            $nwfeedsGroup->get('/arcgamesps4', [Neverwinterfeeds::class, 'get_ps4']);
            $nwfeedsGroup->get('/arcgamesforum', [Neverwinterfeeds::class, 'get_forum']);
            $nwfeedsGroup->get('/officialreddit', [Neverwinterfeeds::class, 'get_reddit']);
            Routes::add404CatchAll($nwfeedsGroup);
        });

        $v1Group->group('/articles', function (\Slim\Routing\RouteCollectorProxy $articlesGroup) {
            $articlesGroup->get('/discussiontags', [Articles::class, 'get_tags']);
            $articlesGroup->get('/all', [Articles::class, 'get']);
            Routes::add404CatchAll($articlesGroup);
        });

        $v1Group->group('/infohub', function (\Slim\Routing\RouteCollectorProxy $infohubGroup) {
            $infohubGroup->post('/source', [Infohub::class, 'post_source']);
            Routes::add404CatchAll($infohubGroup);
        });
    }

    /**
     * @param mixed $group
     * should be Slim\Routing\RouteCollectorProxy or Slim\App
     *
     * @return void
     */
    private static function add404CatchAll($group)
    {
        $allowedClasses = ['Slim\Routing\RouteCollectorProxy', 'Slim\App'];

        if (!\in_array(get_class($group), $allowedClasses)) {
            return;
        }

        $group->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
            throw new HttpNotFoundException($request);
        });
    }
}
