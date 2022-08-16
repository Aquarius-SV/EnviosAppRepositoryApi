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

Route::get('/test', function () {
    return view('login.new-password');
});

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
Route::get('/registro-repartidor', function () {
    return view('login.register-driver');
})->middleware('islogin');

Route::get('/pedidos','PedidoRenderController@index')->middleware(['isnotlogin','emailisverify','roleR']);
Route::get('/pedidos/rechazados','PedidoRenderController@rechazados')->middleware(['isnotlogin','emailisverify']);
Route::get('/pedidos/pendientes','PedidoRenderController@pendientes')->middleware(['isnotlogin','emailisverify']);
Route::get('/pedidos/completados','PedidoRenderController@completados')->middleware(['isnotlogin','emailisverify']);
Route::get('/mis-pedidos','PedidoRenderController@pedidosRepartidor')->middleware(['isnotlogin','emailisverify','roleC']);

Route::get('/test','PedidoRenderController@test');



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
