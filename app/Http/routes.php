<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        if (Config::get('app.simulateBottleneck')){
            $timeToWait = Config::get('app.simulateBottleneck_root');
            $percentage = Config::get('app.simulateBottleneckProbability_root');
            if (rand(0,100)<=$percentage)
                usleep($timeToWait * 1000);
        }
        return view('welcome');
    });
});

// Route::group(['middleware' => 'web'], function () {
//     Route::auth();

//     Route::get('/home', 'HomeController@index');
// });

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home',                 ['as' => 'home',        'uses' => 'HomeController@index']);
    Route::get('/top',                  ['as' => 'top',         'uses' => 'TopController@index']);
    Route::get('/lobby',                ['as' => 'game.lobby',  'uses' => 'GameController@lobby']);
    Route::get('/game/{id}/{join?}',    ['as' => 'game.show',   'uses' => 'GameController@showGame']);
    Route::post('/createGame',          ['as' => 'game.create', 'uses' => 'GameController@createGame']);
    Route::post('/joinGame/{id}',       ['as' => 'game.join',   'uses' => 'GameController@joinGame']);
    Route::delete('/deleteGame',        ['as' => 'game.delete', 'uses' => 'GameController@deleteGame']);
    Route::post('/startGame/{id}',      ['as' => 'game.start',  'uses' => 'GameController@startGame']);
    Route::post('/endGame',             ['as' => 'game.end',    'uses' => 'GameController@endGame']);

});
