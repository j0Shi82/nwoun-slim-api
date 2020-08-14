<?php

namespace App\Application;

use Slim\Exception\HttpNotFoundException;
use App\Controller\V1\Devtracker\Postlist;
use App\Controller\V1\Devtracker\Devinfo;
use App\Controller\V1\Devtracker\Devlist;
use App\Controller\V1\Devtracker\Topiclist;
use App\Controller\V1\Neverwinterfeeds;
use App\Controller\V1\Infoaggregates\Discussion;
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
            Routes::addDevtracker($v1Group);
            Routes::add404CatchAll($v1Group);
        })->add(new Cors());
        
        $app->options('/{routes:.+}', function ($request, $response, $args) {
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
    private static function addDevtracker(\Slim\Routing\RouteCollectorProxy $v1Group)
    {
        $v1Group->group('/devtracker', function (\Slim\Routing\RouteCollectorProxy $devtrackerGroup) {
            $devtrackerGroup->get('/list', [Postlist::class, 'get']);
            $devtrackerGroup->get('/devinfo', [Devinfo::class, 'get']);
            $devtrackerGroup->get('/devlist', [Devlist::class, 'get']);
            $devtrackerGroup->get('/topiclist', [Topiclist::class, 'get']);
            Routes::add404CatchAll($devtrackerGroup);
        });

        $v1Group->group('/nwfeeds', function (\Slim\Routing\RouteCollectorProxy $nwfeedsGroup) {
            $nwfeedsGroup->get('/arcgamespc', [Neverwinterfeeds::class, 'get_pc']);
            $nwfeedsGroup->get('/arcgamesxbox', [Neverwinterfeeds::class, 'get_xbox']);
            $nwfeedsGroup->get('/arcgamesps4', [Neverwinterfeeds::class, 'get_ps4']);
            $nwfeedsGroup->get('/arcgamesforum', [Neverwinterfeeds::class, 'get_forum']);
            $nwfeedsGroup->get('/officialreddit', [Neverwinterfeeds::class, 'get_reddit']);
            Routes::add404CatchAll($nwfeedsGroup);
        });

        $v1Group->group('/infoaggregates', function (\Slim\Routing\RouteCollectorProxy $infoaggrGroup) {
            $infoaggrGroup->get('/discussion', [Discussion::class, 'get']);
            $infoaggrGroup->get('/discussiontags', [Discussion::class, 'get_tags']);
            Routes::add404CatchAll($infoaggrGroup);
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
