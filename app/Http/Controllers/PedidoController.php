<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use App\Models\ExpoNotification;
class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pedidos = Pedido::join('repartidores', 'pedidos.id_repartidor', '=', 'repartidores.id')->join('users', 'pedidos.id_usuario', '=', 'users.id')->where([
            ['repartidores.id', 48],
            ['pedidos.estado', 0]
        ])->select('pedidos.*', 'users.name')->orderBy('pedidos.id', 'desc')->get();
        
        return $pedidos;
    }

    /**
     * Api index method
     * 
    **/

    public function indexApi($id, Request $request)
    {
        $pedidos = Pedido::join('repartidores', 'pedidos.id_repartidor', '=', 'repartidores.id')->join('users', 'pedidos.id_usuario', '=', 'users.id')->where([
            ['repartidores.id', $id],
            ['pedidos.estado', 0]
        ])->select('pedidos.*', 'users.name')->orderBy('pedidos.id', 'desc')->get();
        
        return $pedidos;
    }

    /* public callClientData($id) {
        $clients = Pedido::join('users', 'repartidores.id_usuario', '=', 'users.id')->where([['pedidos.id_usuario', $id],['estado', 0]])->
    } */

    public function changeStatement(Request $request, $id)
    {
        $state = $request->state;
        if ($state == 7)
        {
            $motivo = $request->motivo;
        }
        if ($state == 3)
        {
            $expo = ExpoNotification::where('id_user',$request ->user('api')->id)->get();
            $messages = [           
                new ExpoMessage([
                    'title' => 'Actualización de pedido',
                    'body' => 'Pedido aceptado correctamente',
                ]),];
                foreach ($expo as $ex ) {
                    (new Expo)->send($messages)->to([$ex->expo_token])->push();
                }
        }
        

        Pedido::where('id', $id)->update([
            'pedidos.estado' => $state,
            'pedidos.motivo' => isset($motivo) ? $motivo : NULL
        ]);
    }

    /**
      * Api return all with accept state
     **/
    public function getActiveState($id)
    {
        $pedidos = Pedido::join('repartidores', 'pedidos.id_repartidor', '=', 'repartidores.id')->join('users', 'pedidos.id_usuario', '=', 'users.id')->where([
            ['repartidores.id', $id],
            ['pedidos.estado', 2]
        ])->orWhere([['repartidores.id', $id],['pedidos.estado', 3]])->select('pedidos.*', 'users.name as title')->orderBy('pedidos.estado', 'desc')->get();
        
        return $pedidos;
    }

    public function getNewActiveState($id)
    {
        $pedidos = Pedido::join('repartidores', 'pedidos.id_repartidor', '=', 'repartidores.id')->join('users', 'pedidos.id_usuario', '=', 'users.id')->where([
            ['repartidores.id', $id],
            ['pedidos.estado', 4]
        ])->orWhere([['repartidores.id', $id],['pedidos.estado', 5]])->select('pedidos.*', 'users.name as title')->orderBy('pedidos.id', 'desc')->get();
        
        return $pedidos;
    }

    /** 
     * Generate QR Code
     **/
    public function generate() 
    {
        $pedidos = Pedido::get();
        return view('qrcode')->with('pedidos', $pedidos);
    }

    /** 
     * Finished state
     **/
    public function finish($id)
    {
        $pedidos = Pedido::join('repartidores', 'pedidos.id_repartidor', '=', 'repartidores.id')->join('users', 'pedidos.id_usuario', '=', 'users.id')->where([
            ['repartidores.id', $id],
            ['pedidos.estado', 6]
        ])->select('pedidos.*', 'users.name as title')->orderBy('pedidos.estado', 'desc')->get();
        
        return $pedidos;
    } 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
