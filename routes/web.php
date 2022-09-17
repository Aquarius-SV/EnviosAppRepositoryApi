<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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


Route::get('/restablecimiento/{user}', function (Request $request) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    $user_id = $request->user;
 
    return view('login.new-password')->with('user_id', $user_id);

})->name('restablecimiento');


Route::get('/intermedario/{punto}', function (Request $request) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    
 
    return view('admin.intermediario-register')->with('punto', $request->punto);

})->name('intermediacion');



Route::get('/registro-comercio', function (Request $request) {

    if (! $request->hasValidSignature()) {
        abort(401);
    }

    return view('login.register-comercio');
})->middleware('islogin')->name('registro-comercio');





/* Route::get('/test', function () {
    return view('login.new-password');
}); */

Route::get('/', function () {
    return view('inicio');
});

Route::get('/restablecer-contreseña', function () {
    return view('login.forgot');
});

Route::get('/inicio-sesion', function () {
    return view('login.login');
})->middleware('islogin');

Route::get('/registro', function () {
    return view('login.register');
})->middleware('islogin');

/* Route::get('/registro-repartidor', function () {
    return view('login.register-driver');
})->middleware('islogin'); */

/*Comercio */
Route::get('/pedidos','PedidoRenderController@index')->middleware(['isnotlogin','emailisverify','roleR','roleA','RoleI']);
Route::get('/pedidos/rechazados','PedidoRenderController@rechazados')->middleware(['isnotlogin','emailisverify','roleR','roleA','RoleI']);
Route::get('/pedidos/pendientes','PedidoRenderController@pendientes')->middleware(['isnotlogin','emailisverify','roleR','roleA','RoleI']);
Route::get('/pedidos/completados','PedidoRenderController@completados')->middleware(['isnotlogin','emailisverify','roleR','roleA','RoleI']);
Route::get('/pedidos/devoluciones','PedidoRenderController@devoluciones')->middleware(['isnotlogin','emailisverify','roleR','roleA','RoleI']);
Route::get('/pedidos/direcciones-clientes','PedidoRenderController@direccionesClientes')->middleware(['isnotlogin','emailisverify','roleR','roleA','RoleI']);
Route::get('/pedidos/mis-direcciones','PedidoRenderController@indexDirecciones')->middleware(['isnotlogin','emailisverify','roleR','roleA','RoleI']);
/*End Comercio */

/*repartidor*/
Route::get('/mis-pedidos','PedidoRenderController@pedidosRepartidor')->middleware(['isnotlogin','emailisverify','roleC','roleA','RoleI']);
/*End repartidor*/

/*Administracion*/
Route::middleware(['isnotlogin','emailisverify','roleR','roleC','RoleI'])->prefix('administracion')->group(function () {
    Route::get('/','AdminController@IndexRepartidores');
    Route::get('/repartidores','AdminController@IndexRepartidores');  
    Route::get('/pedidos','AdminController@IndexPedidos');
    Route::get('/puntos-de-reparto','AdminController@IndexRepartos');
    Route::get('/administradores-puntos-reparto','AdminController@IndexAdmin'); 
    
    Route::get('/creacion-pedidos','AdminController@createPedido');

    Route::get('/direcciones-recogida','AdminController@direccionesRecogida');
    Route::get('/datos-cliente','AdminController@datosClientes');
    Route::get('/direcciones-clientes-finales','AdminController@direccionesClientes');

    Route::get('/pedidos-puntos-repartos','AdminController@IndexPedidosPunto');

    Route::get('/comercios','AdminController@indexComercios');
});


Route::middleware(['isnotlogin','emailisverify','roleR','roleC','roleA'])->prefix('puntos-repartos')->group(function () {
    Route::get('/','PedidoRenderController@pedidosZonas');
    Route::get('/asignacion','PedidoRenderController@asignacionPedidos');
    Route::get('/completados','PedidoRenderController@pedidosCompletados');
    Route::get('/direcciones-clientes','PedidoRenderController@direccionesClientes');    
    
    
    
});





//Route::get('/administracion','AdminController@IndexRepartidores')->middleware(['isnotlogin','emailisverify','roleR','roleC']);
/*En administracion*/






Route::get('/codigo-verificacion',function(){
    return view('correo.generador');
})->middleware(['isnotlogin','emailisnotverify']);



Route::get('logout',[App\Http\Controllers\cerrarSesionController::class, 'logout']);




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* Added Routes For confirmation */
Route::get('/verificate-email/{user}', function (Request $request) {
    $user = User::where('email', $request->user)->first();
    Auth::login($user);
    return redirect('/codigo-verificacion');
    //return $request->user;
})->name('verificate.email')->middleware(['signed']);



Route::get('/eliminar-cuenta', 'EliminarCuentaController@index')/* ->middleware(['isnotlogin','emailisverify']) */;
Route::get('/eliminar-cuenta/{email}', 'EliminarCuentaController@api');
