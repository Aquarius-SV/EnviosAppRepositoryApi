<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $allPedidos = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
       ->select('repartidores.id_usuario','repartidores.id as id_repartidor','pedidos.direccion_entrega','pedidos.direccion_recogida','pedidos.estado',
       'pedidos.id as id_pedido','pedidos.tel_cliente','pedidos.peso','pedidos.size','pedidos.fragil')
       ->where('pedidos.id_usuario',Auth::user()->id)->get();

      

       return view('admin.pedidos')->with('allp',$allPedidos);
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function completados()
    {
        $allPedidos = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
       ->select('repartidores.id_usuario','repartidores.id as id_repartidor','pedidos.direccion_entrega','pedidos.direccion_recogida','pedidos.estado',
       'pedidos.id as id_pedido','pedidos.tel_cliente','pedidos.peso','pedidos.size','pedidos.fragil')
       ->where('pedidos.id_usuario',Auth::user()->id)->where('pedidos.estado',6)->get();

       return view('admin.pedidos-completados')->with('allp',$allPedidos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function rechazados(Request $request)
    {
        $allPedidos = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
        ->select('repartidores.id_usuario','repartidores.id as id_repartidor','pedidos.direccion_entrega','pedidos.direccion_recogida','pedidos.estado',
        'pedidos.id as id_pedido','pedidos.tel_cliente','pedidos.peso','pedidos.size','pedidos.fragil')
        ->where('pedidos.id_usuario',Auth::user()->id)->where('pedidos.estado',7)->get();
 
        return view('admin.pedidos-rechazados')->with('allp',$allPedidos);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pendientes()
    {
        $allPedidos = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
        ->select('repartidores.id_usuario','repartidores.id as id_repartidor','pedidos.direccion_entrega','pedidos.direccion_recogida','pedidos.estado',
        'pedidos.id as id_pedido','pedidos.tel_cliente','pedidos.peso','pedidos.size','pedidos.fragil')
        ->where('pedidos.id_usuario',Auth::user()->id)->where('pedidos.estado',0)->get();
 
        return view('admin.pedidos-pendientes')->with('allp',$allPedidos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pedidosRepartidor()
    {

        $repartidor = User::join('repartidores','repartidores.id_usuario','=','users.id')->select('repartidores.id')->where('users.id',Auth::user()->id)->get();



        $allPedidos = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->select('pedidos.direccion_entrega',
        'pedidos.direccion_recogida','pedidos.estado','pedidos.id as id_pedido','pedidos.id_usuario')
        ->where('pedidos.id_repartidor',$repartidor[0]->id)->get();

        return view('admin.repartidores')->with('allp',$allPedidos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
