<?php

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
 
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ])); 
    // $routes->applyMiddleware('csrf');
 
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
    // $routes->connect('/admin/addadmin', ['controller' => 'admin', 'action' => 'addadmin']);
    
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);


 
    $routes->fallbacks(DashedRoute::class);
});
 