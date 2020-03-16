<?php

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

$router->group(['prefix' => 'api/v1'], function ($router) {
    $router->post('admin/login', ['uses' => 'AdminController@login_action']);
    $router->get('teams/{id}', ['uses' => 'TeamController@showOneTeam']);
    $router->get('teams', ['uses' => 'TeamController@showAllTeams']);

    $router->post('playerbyteam', ['uses' => 'PlayerController@showPlayerbyteam']);
    $router->post('search_player', ['uses' => 'PlayerController@showOnePlayer']);
});


$router->group(['middleware' => ['jwt.auth'], 'prefix' => 'api/v1'], function ($router) {

    $router->post('teams', ['uses' => 'TeamController@store']);
    $router->delete('teams/{id}', ['uses' => 'TeamController@delete']);
    $router->post('players', ['uses' => 'PlayerController@store']);
    $router->delete('players/{id}', ['uses' => 'PlayerController@delete']);
});
