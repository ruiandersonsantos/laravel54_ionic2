<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

 /*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


\ApiRoute::version('v1',function(){

    // Grupo que controla todas as rotas da API
    ApiRoute::group(['namespace' => 'CodeFlix\Http\Controllers\Api', 'as' => 'api'],function (){

        // Rota para fazer login - cria um token novo
        ApiRoute::post('/access_token',[
            'uses' => 'AuthController@accessToken',
            'middleware'=> 'api.throttle',
            'limit' => 10,
            'expires' => 1
        ])->name('.access_token');

        ApiRoute::post('/refresh_token',[
            'uses' => 'AuthController@refreshToken',
            'middleware'=> 'api.throttle',
            'limit' => 10,
            'expires' => 1
        ])->name('.refresh_token');

        // Grupo de rotas protegidos por autenticação e limite de acesso
        ApiRoute::group([
            'middleware'=> ['api.throttle','api.auth'],
            'limit' => 100,
            'expires' => 3
        ], function (){

            // Rota que faz o logout da API
            ApiRoute::post('/logout','AuthController@logout');

            // Rota de testes
            ApiRoute::get('test',function (){
                return "Opa !! Estou autenticado";
            });
            ApiRoute::get('/user',function(Request $request){
                return $request->user('api');
            });
        });

    });

});
