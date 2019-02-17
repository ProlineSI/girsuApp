<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//['register' => false] pasar esto como argumento para deshabilitar la registracion de nuevos usuarios
Auth::routes();

Route::get('/home', 'HomeController@index')->name('homeAcreditados');

Route::get('/home/datatable', 'HomeController@dataTableAcreditados')->name('datatable.acreditados');

Route::get('/inscriptos', 'InscriptosController@index')->name('inscriptos');

Route::get('/inscriptos/datatable', 'InscriptosController@dataTableInscriptos')->name('datatable.inscriptos');

Route::post('/webhookAcreditado', 'webhookController@acreditar')->name('webhookAcreditado');

Route::post('/webhookDesacreditado', 'desacreditadoController@desacreditar')->name('webhookDesacreditado');

Route::post('/webhookInscripto', 'webhookInscriptoController@inscribir')->name('webhookInscripto');

Route::post('/certificadoVirtual', 'HomeController@mailVirtualIndividual');

Route::post('/mailGral', 'HomeController@mailGral');

Route::post('/certificadoPre/{id}', 'HomeController@imprimirPreImpreso');

Route::post('/credencial/{id}', 'webhookController@imprimirCredencialVista');

Route::post('/impresionGral', 'HomeController@impresionGral');


//RUTA QUE SIRVE PARA INSTALAR MIGRACIONES DE LARAVEL
Route::get('install', function() {
    //Artisan::call('migrate');
    $response = shell_exec("composer.phar install");
    //if ($response == NULL){
    //    render('home');
    //}
    echo($response);
    //render('home');
});


