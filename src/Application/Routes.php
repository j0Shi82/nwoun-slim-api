<?php

namespace App\Application;

use Slim\Exception\HttpNotFoundException;
use App\Controller\V1\Devtracker\Postlist;
use App\Controller\V1\Devtracker\Devinfo;
use App\Controller\V1\Devtracker\Devlist;
use App\Controller\V1\Devtracker\Topiclist;
use App\Controller\V1\Neverwinterfeeds;
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
        $app->group('/v1', function (\Slim\Routing\RouteCollectorProxy $v1_group) {
            Routes::addDevtracker($v1_group);
            Routes::add404CatchAll($v1_group);
        })->add(new Cors());
        
        $app->options('/{routes:.+}', function ($request, $response, $args) {
            return $response;
        })->add(new Cors());
        
        Routes::add404CatchAll($app);
    }
    
    /**
     * add devtracker routes
     *
     * @param  \Slim\Routing\RouteCollectorProxy $v1_group
     *
     * @return void
     */
    private static function addDevtracker(\Slim\Routing\RouteCollectorProxy $v1_group)
    {
        $v1_group->group('/devtracker', function (\Slim\Routing\RouteCollectorProxy $devtracker_group) {
            $devtracker_group->get('/list', [Postlist::class, 'get']);
            $devtracker_group->get('/devinfo', [Devinfo::class, 'get']);
            $devtracker_group->get('/devlist', [Devlist::class, 'get']);
            $devtracker_group->get('/topiclist', [Topiclist::class, 'get']);
            Routes::add404CatchAll($devtracker_group);
        });

        $v1_group->group('/nwfeeds', function (\Slim\Routing\RouteCollectorProxy $devtracker_group) {
            $devtracker_group->get('/arcgamespc', [Neverwinterfeeds::class, 'get_pc']);
            $devtracker_group->get('/arcgamesxbox', [Neverwinterfeeds::class, 'get_xbox']);
            $devtracker_group->get('/arcgamesps4', [Neverwinterfeeds::class, 'get_ps4']);
            $devtracker_group->get('/arcgamesforum', [Neverwinterfeeds::class, 'get_forum']);
            $devtracker_group->get('/officialreddit', [Neverwinterfeeds::class, 'get_reddit']);
            Routes::add404CatchAll($devtracker_group);
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
