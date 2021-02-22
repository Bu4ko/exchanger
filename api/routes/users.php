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

//$router->get('/', function () use ($router) {
//    dd(app('db'));
//    return $router->app->version();
//});

//$router->get('/pong', function (\Illuminate\Http\Request $request) use ($router) {
//    $controller = $router->app->make('App\Users\Http\Controllers\Controller');
//    return $controller->pong($request);
//});
//$router->get('/pong', 'Controller@pong');
