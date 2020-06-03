<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'UsersController@login');
Route::post('signup', 'UsersController@signup');

// Route::get('aux', 'UserController@login');
// Route::post('aux', 'UserController@login');
// Route::get('aux/{id}', 'UserController@signup');
// Route::put('aux/{id}', 'UserController@signup');
// Route::delete('aux/{id}', 'UserController@signup');

// Route::get('cliente', 'UserController@login');
// Route::post('cliente', 'UserController@login');
Route::get('usuario/{id}', 'UsersController@get');
Route::put('usuario/{id}', 'UsersController@update');
Route::delete('usuario/{id}', 'UsersController@delete');
Route::get('usuario/{id}/catalogo', 'UsersController@catalogos');

Route::post('catalogo', 'CatalogoController@create');
Route::get('catalogo/{id}', 'CatalogoController@get');
Route::put('catalogo/{id}', 'CatalogoController@update');
Route::delete('catalogo/{id}', 'CatalogoController@delete');

Route::get('prestamo/{id}', 'PrestamoController@getAll');
Route::post('prestamo', 'PrestamoController@create');
Route::put('prestamo/{id}', 'PrestamoController@update');
Route::post('prestamo', 'PrestamoController@get');

Route::post('pedido', 'PedidoController@create');
Route::get('pedido/{id}', 'PedidoController@get');
Route::put('pedido/{id}', 'PedidoController@update');
Route::get('pedido/admmin/{id}', 'PedidoController@getAdmin');
Route::get('pedido/usuario/{id}', 'PedidoController@getUser');

Route::get('pedido/detalle/{id}', 'PedidoController@getDetalle');
Route::post('pedido/detalle', 'PedidoController@addDetalle');
Route::put('pedido/detalle/{id}', 'PedidoController@updateDetalle');
Route::delete('pedido/detalle/{id}', 'PedidoController@deleteDetalle');

Route::get('pago/{id}', 'PedidoController@getDetalle');
Route::get('pago/admin/{id}', 'PedidoController@getDetalle');
Route::get('pago/usuario/{id}', 'PedidoController@getDetalle');
Route::post('pago', 'PedidoController@addDetalle');
Route::put('pago/{id}', 'PedidoController@updateDetalle');
Route::delete('pago/{id}', 'PedidoController@deleteDetalle');