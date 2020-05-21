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

$router->get('/import-league/{leagueCode}', 'Controller@getImportLeague');
$router->get('/total-players/{leagueCode}', 'Controller@getTotalPlayers');
$router->get('/', function() {
    return response()->json([], 404);
});
$router->get('{any}', function() {
    return response()->json([], 404);
});
