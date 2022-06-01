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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/pedidos/{id}','PedidoApiController@index');

Route::post('/pedidos/login','PedidoApiController@userLogin');
Route::post('/pedidos/logout','PedidoApiController@logoutUser');

Route::get('/pedidos/zonas/{id}','PedidoApiController@deliveryZones');
Route::get('/zonas/all','PedidoApiController@allZonesDelivery');
Route::post('/pedidos/new','PedidoApiController@storePedido');