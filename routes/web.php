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

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->get('/user/login','UserController@login');
$router->get('/user/login/{hash}','UserController@allowLogin');
$router->post('/verify-user','UserController@verifyUser');
$router->post('/user/create','UserController@create');
$router->get('/user/{user}','UserController@details');
$router->post('/user/{user}/update','UserController@update');

