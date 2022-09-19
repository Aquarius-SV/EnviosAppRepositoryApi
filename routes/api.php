<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Notifications\NewLikeNotification;
use Illuminate\Support\Facades\URL;
use App\Models\{ User, ExpoNotification };
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailApi;
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

Route::get('/estados/pedidos/clientes/{id}','PedidoApiController@checkStatePedidoClient');

Route::post('/pedidos/login','PedidoApiController@userLogin');
Route::post('/pedidos/logout/{email}','PedidoApiController@logoutUser');

Route::get('/pedidos/zonas/{id}','PedidoApiController@deliveryZones');
Route::get('/zonas/all','PedidoApiController@allZonesDelivery');
Route::post('/pedidos/new','PedidoApiController@storePedido');
Route::post('/pedidos/update/{id}','PedidoApiController@updatePedido');
Route::post('/pedidos/repartidor/update/{id}','PedidoApiController@updateRepartidor');

Route::post('/pedidos/states/preparado/{id}','PedidoApiController@statePreparacion');
Route::post('/pedidos/states/recoger/{id}','PedidoApiController@stateRecoger');

Route::get('/send-mail/{email}', function(Request $request) {
    $url = URL::signedRoute(
        'verificate.email',
        ['user' => $request->email]
    );

    Mail::to($request->email)->send(new SendMailApi($request->email, $url));
});

///APP MOVIL
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');
    Route::post('validate', 'AuthController@realTimeValidation');
    Route::get('zonas/{id}', function ($id) {
        $zonas = \DB::table('zonas')->where([
            ['estado', 1],
            ['id_municipio', $id]
        ])->select('id as value', 'nombre as label')->limit(3)->get();
        return $zonas;
    });

    Route::get('departamentos', function () {        
        try {
            $dpts = \DB::table('departamentos')->select('id as value', 'nombre as label')->get();
            return $dpts;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    });

    Route::get('municipios/{id}', function ($id) {        
        try {
            $mns = \DB::table('municipios')->where('id_departamento', $id)->select('id as value', 'nombre as label')->get();
            return $mns;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    });

    Route::get('corroborate-state/{id}', function ($id) {
        $state = \DB::table('repartidores')->where('id_usuario', $id)->value('estado');
        return $state;
    });

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::get('pedidos/{id}', 'PedidoController@indexApi');
        Route::get('pedidos/{id}/enproceso', 'PedidoController@getActiveState');
        Route::get('pedidos/{id}/enproceso/state', 'PedidoController@getNewActiveState');
        Route::post('pedidos/changeState/{id}', 'PedidoController@changeStatement');
        Route::get('pedidos/{id}/finalizados', 'PedidoController@finish');
        Route::post('push', function(Request $request) {
            $user = $request->user('api');
            /* $userOwner = User::whereId($user->id)->firstOrFail(); */
            /* $userOwner->remember_token = $request->expo_token;
            $userOwner->update(); */
            /* $pushToken = new ExpoNotification;
            $pushToken->dispositivo = $request->dispositivo;
            $pushToken->expo_token = $request->expo_token;
            $pushToken->id_user = $user->id;
            $pushToken->save(); */

            $pushToken = ExpoNotification::firstOrCreate(
                ['expo_token' => $request->expo_token, 'id_user' => $user->id],
                ['dispositivo' => $request->dispositivo]
            );
            /* $userOwner->notify(new NewLikeNotification($request->expo_token)); */
            return $pushToken;
        });
        Route::get('get-points/{municipio}', 'PedidoController@trackPoint');
        Route::post('store-new-point/{pedido}/{punto}', 'PedidoController@storePoint');
        Route::get('devoluciones/{id}', 'PedidoController@returnPackages');
        Route::get('onComplete/{id}/{idP}/{idPP}', 'PedidoController@ifId');
        Route::post('onCompleteButNotId', 'PedidoController@noId');
        Route::post('pedidos/finishStates', 'PedidoController@finishState');
        Route::get('entrega-mail/{email}/{id_pedido}/{ext}', 'PedidoController@clientProblem');
    });
});