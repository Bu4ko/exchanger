<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/', ['uses' => 'Controller@index']);

//$router->post('/', function () use ($router) {
//    $controller = $router->app->make('App\FinanceManager\Http\Controllers\Controller');
//    return $controller->ping();
//});

$router->get('/', function () use ($router) {
    return $router->app->version();
});
