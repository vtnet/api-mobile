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


// $app->post('/user', function() use ($app) {

// 	$retorno['a']=true;
// 	$retorno['created']=true;
// 	$retorno['b']=true;

//     return response()->json($retorno);
// });

  

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers', 'middleware' => 'headerjson'], function($app)
{
    ## Autenticação
    $app->post('login','LoginController@get');

    $app->get('voz','MobileRequest@index');
    $app->post('voz','MobileRequest@create');
  
    // $app->get('teste/{id}','MobileRequest@getbook');
    // $app->put('teste/{id}','MobileRequest@updateBook');
    // $app->delete('teste/{id}','MobileRequest@deleteBook');
   
});


$app->group(['prefix' => 'api/v1','middleware' => ['token', 'headerjson'], 'namespace' => 'App\Http\Controllers'], function ($app) {

    // dd($token);
     $app->post('mobile','MobileController@create');     
    
});





