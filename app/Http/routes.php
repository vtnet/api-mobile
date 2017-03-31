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

/*
Forma antiga
 */

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers', 'middleware' => ['headerjson','throttle:30,1']], function($app)
{
    $app->get('voz','MobileRequest@index');
    $app->post('voz','MobileRequest@create');
  
});



/*
    Não esta verificando token
 */
$app->group(['prefix' => 'v1','namespace' => 'App\Http\Controllers', 'middleware' => ['headerjson','throttle:30,1']], function($app)
{
    ## Autenticação
    $app->post('login','LoginController@get');   
});



$app->group(['prefix' => 'v1','middleware' => ['token', 'headerjson'], 'namespace' => 'App\Http\Controllers'], function ($app) {

    /**
     * EndPoint Definido OK
     */
    $app->post('mobile','MobileController@postTeste');     
    $app->get('mobile','MobileController@indexTeste'); 



    /**
     * Desenvolvimento
     */
     $app->post('develop','MobileController@post');     
     $app->get('develop','MobileController@index');     
    
});





