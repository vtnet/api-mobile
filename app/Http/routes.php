<?php

use App\Http\Controllers\JobsController;
use Illuminate\Http\Request;
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


$app->get('csv','MobileController@csv');



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

    /**
     * Regra de negocio, chamando direto a funcao
     */
    $app->post('regras', function(Request $request) use ($app) {

        // dd($request->User);

        $telefones_id=$request->User->id;
        $arr =  json_encode($request->all());

        // dd($telefones_id);
        $jobsController = new JobsController();
        $jobsController -> insertConsumo($telefones_id, $arr);

        return $app->version();  
    });
    
});





