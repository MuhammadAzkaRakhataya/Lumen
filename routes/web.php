<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version(); 
    
});

$router->group(['middleware' => "cors"], function ($router) {

$router->get('stuff', 'StuffController@index');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');
$router->get('/profile', 'AuthController@me');




//manggil method index dari StuffController buat menangani permintaan
$router->get('/stuffs', 'StuffContoller@index');


//route di dalem ini berawalan stuff   //callback funtion yang ber definisi route yg di kelompokan
$router->group(['prefix' => 'stuff'], function() use ($router) {
    //static routes
    $router->get('/data', 'StuffController@index');
    $router->post('/{id}', 'StuffController@store');
    $router->get('/trash', 'StuffController@trash');

    //dynamic routes \nilai dinamis dari url
    $router->get('/{id}', 'StuffController@show');
    $router->patch('/{id}', 'StuffController@update');
    $router->delete('/{id}', 'StuffController@destroy');
    $router->get('/restore/{id}', 'StuffController@restore');
    $router->delete('/permanent/{id}', 'StuffController@deletePermanent');
}); 


$router->group(['prefix' => '/user'], function() use ($router) {
    //static routes
    $router->get('/', 'UserController@index');
    $router->post('/', 'UserController@store');
    $router->get('/trash', 'UserController@trash');
    $router->post('/login', 'UserController@trash');
    
    $router->post('/store', 'UserController@store');
    
    //dynamic routes \nilai dinamis dari url
    $router->get('show/{id}', 'UserController@show');
    $router->patch('update/{id}', 'UserController@update');
    $router->delete('/{id}', 'UserController@destroy');
    $router->get('/restore/{id}', 'UserController@restore');
    $router->delete('/permanent/{id}', 'UserController@deletePermanent');
    // $router->post('/permanent/{id}', 'UserController@login');
    // $router->get('/permanent/{id}', 'UserController@logout');
}); 


$router->group(['prefix' => 'stuff-stock/', 'middleware' => 'auth'],function() use ($router) {

    // $router->get('/', 'StuffStockController@index');
    // $router->post('store', 'StuffStockController@store');

    // $router->get('detail/{id}', 'StuffStockController@show');
    // $router->patch('update/{id}', 'StuffStockController@update');
    $router->delete('delete/{id}', 'StuffStockController@destroy');
    $router->get('recycle-bin', 'StuffStockController@recycle-bin');
    $router->get('/restore/{id}', 'StuffStockController@restore');
    $router->get('force-delete/{id}', 'StuffStockController@forceDestroy');
     $router->post('add-stock/{id}', 'StuffStockController@addStock');
     $router->post('sub-stock/{id}', 'StuffStockController@subStock');
});


$router->group(['prefix' => 'inbound-stuff/', 'middleware' => 'auth'],function() use ($router) {

    $router->get('data/', 'InboundStuffController@index');
    $router->post('store', 'InboundStuffController@store');

    $router->get('detail/{id}', 'InboundStuffController@show');
    $router->patch('update/{id}', 'InboundStuffController@update');
    $router->delete('delete/{id}', 'InboundStuffController@destroy');
    $router->get('recycle-bin', 'InboundStuffController@recycle-bin');
    $router->get('/restore/{id}', 'InboundStuffController@restore');
    $router->get('force-delete/{id}', 'InboundStuffController@forceDestroy');
});


$router->group(['prefix' => 'lending'], function() use ($router) {
    $router->get('/', 'LendingController@index');
    $router->post('store', 'LendingController@store');
    $router->get('detail/{id}', 'LendingController@show');
    $router->patch('update/{id}', 'LendingController@update');
});


$router->group(['prefix' => 'restoration'], function() use ($router) {
    //          $router->get('data/', 'RestorationController@index');
    $router->post('store/', 'RestorationController@store');

});

});