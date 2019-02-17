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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/certificadoVirtual/{id}', 'HomeController@mailVirtualIndividual');

Route::post('/certificadoPre/{id}', 'HomeController@imprimirPreImpreso');

Route::post('/credencial/{id}', 'webhookController@imprimirCredencial');

Route::post('/impresionGral', 'HomeController@impresionGral');

Route::post('/mailGral', 'HomeController@mailGral');