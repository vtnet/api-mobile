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

$app->get('/', function() use ($app) {
    return $app->version();  
});

$app->get('/jorge', function() use ($app) {
    return "Lumen RESTful API By CoderExample (https://coderexample.com)";
});
 
$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function($app)
{
    $app->get('voz','MobileRequest@index');
  
    // $app->get('teste/{id}','MobileRequest@getbook');
      
    $app->post('voz','MobileRequest@create');
      
    // $app->put('teste/{id}','MobileRequest@updateBook');
      
    // $app->delete('teste/{id}','MobileRequest@deleteBook');
});