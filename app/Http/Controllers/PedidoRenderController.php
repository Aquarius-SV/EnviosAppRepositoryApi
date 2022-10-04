<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{Pedido,PuntoReparto,DetallePuntoReparto,Direccion};
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class PedidoRenderController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $allPedidos = Pedido::leftJoin('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
       ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')
       ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')
       ->select('repartidores.id_usuario','repartidores.id as id_repartidor','municipios.nombre as municipio','departamentos.nombre as departamento'
       ,'departamentos.id as id_departamento','pedidos.*','pedidos.estado as estado_pedido','direcciones_clientes.*','direcciones_clientes.estado as estado_direccion','pedidos.id as id_pedido')
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
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->select('repartidores.id_usuario','repartidores.id as id_repartidor','municipios.nombre as municipio','departamentos.nombre as departamento'
        ,'departamentos.id as id_departamento','pedidos.*')
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
        $allPedidos =  Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->select('repartidores.id_usuario','repartidores.id as id_repartidor','municipios.nombre as municipio','departamentos.nombre as departamento'
        ,'departamentos.id as id_departamento','pedidos.*')
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
        $allPedidos =  Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->select('repartidores.id_usuario','repartidores.id as id_repartidor','municipios.nombre as municipio','departamentos.nombre as departamento'
        ,'departamentos.id as id_departamento','pedidos.*')
        ->where('pedidos.id_usuario',Auth::user()->id)->where('pedidos.estado',0)->get();
 
        return view('admin.pedidos-pendientes')->with('allp',$allPedidos);
    }


    public function devoluciones()
    {
        $allPedidos =  Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')
        ->select('repartidores.id_usuario','repartidores.id as id_repartidor','municipios.nombre as municipio','departamentos.nombre as departamento'
        ,'departamentos.id as id_departamento','pedidos.*','pedidos.estado as estado_pedido','direcciones_clientes.*','pedidos.id as id_pedido')
        ->where('pedidos.id_usuario',Auth::user()->id)->whereIn('pedidos.estado',[11,12,13])->get();
 
        
        return view('admin.devoluciones')->with('allp',$allPedidos);
    }


    public function direccionesClientes()
    {
        $direcciones = User::join('direcciones_clientes','direcciones_clientes.id_usuario','=','users.id')
        ->join('municipios','municipios.id','=','direcciones_clientes.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('direcciones_clientes.id_usuario',Auth::user()->id)
        ->select('direcciones_clientes.*','municipios.nombre as municipio',
        'departamentos.nombre as departamento','departamentos.id as id_departamento')->get();

        return view('admin.direcciones-clientes')->with('direcciones',$direcciones);

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


    



    public function pedidosZonas()
    {       
        $zoneUser = DetallePuntoReparto::join('puntos_repartos','puntos_repartos.id','=','detalles_puntos_repartos.id_punto_reparto')
        ->join('users','users.id','=','detalles_puntos_repartos.id_usuario')->join('municipios','municipios.id','=','puntos_repartos.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('detalles_puntos_repartos.id_usuario',Auth::user()->id)
        ->select('municipios.id as municipio','departamentos.id as departamento','departamentos.nombre as departamento_nombre','detalles_puntos_repartos.id_punto_reparto','puntos_repartos.nombre as punto_reparto')->first();


        $allPedidos = Pedido::join('pedidos_puntos','pedidos_puntos.id_pedido','pedidos.id')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')            
        ->select('municipios.nombre as municipio','departamentos.nombre as departamento','pedidos.*','pedidos_puntos.estado as estado_detalle','pedidos.estado as estado_pedido',
        'pedidos_puntos.id_repartidor as id_repartidor_pedido_punto','direcciones_clientes.*')
        ->where([
            ['pedidos_puntos.id_punto',$zoneUser->id_punto_reparto],            
        ])->whereIn('pedidos_puntos.estado',[0, 3])->get();

      
       return view('admin.intermediario.pedidos-zona')->with('allp',$allPedidos)->with('zona',$zoneUser->punto_reparto);
       
    }

    public function asignacionPedidos()
    {
        $zoneUser = DetallePuntoReparto::join('puntos_repartos','puntos_repartos.id','=','detalles_puntos_repartos.id_punto_reparto')
        ->join('users','users.id','=','detalles_puntos_repartos.id_usuario')->join('municipios','municipios.id','=','puntos_repartos.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('detalles_puntos_repartos.id_usuario',Auth::user()->id)
        ->select('municipios.id as municipio','departamentos.id as departamento','departamentos.nombre as departamento_nombre','detalles_puntos_repartos.id_punto_reparto','puntos_repartos.nombre as punto_reparto')->first();


        $allPedidos = Pedido::join('pedidos_puntos','pedidos_puntos.id_pedido','pedidos.id')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento') 
        ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')               
        ->select('municipios.nombre as municipio','departamentos.nombre as departamento','pedidos.*','pedidos_puntos.estado as estado_detalle','pedidos.estado as estado_pedido','pedidos_puntos.id as id_pedido_punto',
        'pedidos_puntos.id_repartidor as id_repartidor_pedido_punto','pedidos_puntos.id_punto as id_punto','direcciones_clientes.*','pedidos.id as id_pedido')
        ->where([
            ['pedidos_puntos.id_punto',$zoneUser->id_punto_reparto],
            ['pedidos_puntos.estado',1]
        ])->get();



        return view('admin.intermediario.asignacion')->with('allp',$allPedidos)->with('zona',$zoneUser->punto_reparto);
    }


    public function pedidosCompletados()
    {
        $zoneUser = DetallePuntoReparto::join('puntos_repartos','puntos_repartos.id','=','detalles_puntos_repartos.id_punto_reparto')
        ->join('users','users.id','=','detalles_puntos_repartos.id_usuario')->join('municipios','municipios.id','=','puntos_repartos.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('detalles_puntos_repartos.id_usuario',Auth::user()->id)
        ->select('municipios.id as municipio','departamentos.id as departamento','departamentos.nombre as departamento_nombre','detalles_puntos_repartos.id_punto_reparto','puntos_repartos.nombre as punto_reparto')->first();


        $allPedidos = Pedido::join('pedidos_puntos','pedidos_puntos.id_pedido','pedidos.id')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento') 
        ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')               
        ->select('municipios.nombre as municipio','departamentos.nombre as departamento','pedidos.*','pedidos_puntos.estado as estado_detalle','pedidos.estado as estado_pedido',
        'pedidos_puntos.id_repartidor as id_repartidor_pedido_punto','direcciones_clientes.*')
        ->where([
            ['pedidos_puntos.id_punto',$zoneUser->id_punto_reparto],
            ['pedidos_puntos.estado',2]
        ])->get();
        return view('admin.intermediario.completado')->with('allp',$allPedidos)->with('zona',$zoneUser->punto_reparto);
    }



    public function indexDirecciones()
    {

        $direcciones = Direccion::where('id_usuario',Auth::user()->id)->get();



        return view('admin.direcciones-de-comercios')->with('direcciones',$direcciones);
    }


}
