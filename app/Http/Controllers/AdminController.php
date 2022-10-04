<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Repartidor,Pedido,PuntoReparto,Direccion,DireccionClienteModel,Comercio,DetallePuntoReparto,Zona};
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
    public function IndexRepartidores()
    {
        $deliveries = Repartidor::join('users','users.id','=','repartidores.id_usuario')
        
        ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')        
        ->select('users.*','users.estado as estado','users.created_at','repartidores.*','repartidores.id as repartidor','datos_vehiculos.*','users.id as id_user')->get();  

        return view('admin.repartidores-admin')->with('repartidores',$deliveries);
    }


    public function IndexPedidos()
    {
       

       return view('admin.pedidos-admin');
    }

    public function IndexRepartos()
    {
        $puntos = PuntoReparto::join('municipios','municipios.id','=','puntos_repartos.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->select('municipios.nombre as municipio','departamentos.nombre as departamento','puntos_repartos.*')
        ->get();
        return view('admin.puntos-admin')->with('puntos',$puntos);
    }


    public function IndexAdmin()
    {   
        $admins = User::join('datos_intermediarios','datos_intermediarios.id_usuario','=','users.id')
        ->select('users.name as nombre','users.email as correo','datos_intermediarios.dui','datos_intermediarios.direccion',
        'datos_intermediarios.telefono','datos_intermediarios.cargo','users.estado')->get();

        return view('admin.users-admin')->with('admins',$admins);
    }


    public function createPedido()
    {
        /*$allPedidos = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->select('repartidores.id_usuario','repartidores.id as id_repartidor','municipios.nombre as municipio','departamentos.nombre as departamento'
        ,'departamentos.id as id_departamento','pedidos.*')
        ->where('pedidos.id_usuario',Auth::user()->id)->get();*/


        $allPedidos = Pedido::join('users','users.id','=','pedidos.id_usuario')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')
        ->join('pedidos_comercios','pedidos_comercios.id_pedido','=','pedidos.id')
        ->join('comercios','comercios.id','=','pedidos_comercios.id_comercio')       
        ->select('pedidos.*','comercios.nombre as comercio','municipios.nombre as municipio','departamentos.nombre as departamento'
        ,'departamentos.id as id_departamento','direcciones_clientes.nombre as nombre','direcciones_clientes.telefono as telefono',
        'pedidos.estado as pedido_estado','direcciones_clientes.*','pedidos.id as pedido_id')->where('pedidos.id_usuario',Auth::user()->id)->get();

       
        return view('admin.pedidos-create')->with('allp',$allPedidos);
    }


    public function direccionesRecogida()
    {
        $direcciones = Direccion::where('id_usuario',Auth::user()->id)->whereNull('id_comercio')->get();
        return view('admin.direcciones-recogidas')->with('direcciones',$direcciones);
    }


    public function direccionesClientes()
    {
       $direcciones =  DireccionClienteModel::join('municipios','municipios.id','=','direcciones_clientes.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('direcciones_clientes.id_usuario',Auth::user()->id)->select('direcciones_clientes.*',
        'departamentos.nombre as departamento','municipios.nombre as municipio')->get();



        return view('admin.direcciones-clientes-finales')->with('direcciones',$direcciones);
    }


    public function datosClientes()
    {
        $comercios = Comercio::where('id_usuario',Auth::id())->get();
        return view('admin.datos-clientes')->with('comercios',$comercios);
    }



    public function IndexPedidosPunto()
    {
        $zoneUser = DetallePuntoReparto::join('puntos_repartos','puntos_repartos.id','=','detalles_puntos_repartos.id_punto_reparto')
        ->join('users','users.id','=','detalles_puntos_repartos.id_usuario')->join('municipios','municipios.id','=','puntos_repartos.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('detalles_puntos_repartos.id_usuario',Auth::user()->id)
        ->select('municipios.id as municipio','departamentos.id as departamento','departamentos.nombre as departamento_nombre',
        'detalles_puntos_repartos.id_punto_reparto','puntos_repartos.nombre as punto_reparto')->first();


        $allPedidos = Pedido::join('pedidos_puntos','pedidos_puntos.id_pedido','pedidos.id')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')   
        ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')             
        ->select('municipios.nombre as municipio','departamentos.nombre as departamento','pedidos.*','pedidos_puntos.estado as estado_detalle','pedidos.estado as estado_pedido',
        'pedidos_puntos.id_repartidor as id_repartidor_pedido_punto','direcciones_clientes.nombre','direcciones_clientes.telefono',
        'direcciones_clientes.dui','pedidos.id as id_pedido','pedidos_puntos.id as id_pedido_punto','pedidos_puntos.id_punto','pedidos_puntos.show_pedido as show_pedido_punto_pedido')
        ->where([            
            ['pedidos_puntos.id_punto',$zoneUser->id_punto_reparto],            
        ])->whereIn('pedidos_puntos.estado',[0,3])->whereNull('pedidos.negocio')->get();
        

        return view('admin.pedidos-puntos-repartos')->with('allp',$allPedidos)->with('zona',$zoneUser->punto_reparto)->with('type','en tránsito');

    }



    public function IndexPedidosPuntoReasignacion()
    {
        $zoneUser = DetallePuntoReparto::join('puntos_repartos','puntos_repartos.id','=','detalles_puntos_repartos.id_punto_reparto')
        ->join('users','users.id','=','detalles_puntos_repartos.id_usuario')->join('municipios','municipios.id','=','puntos_repartos.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('detalles_puntos_repartos.id_usuario',Auth::user()->id)
        ->select('municipios.id as municipio','departamentos.id as departamento','departamentos.nombre as departamento_nombre',
        'detalles_puntos_repartos.id_punto_reparto','puntos_repartos.nombre as punto_reparto')->first();


        $allPedidos = Pedido::join('pedidos_puntos','pedidos_puntos.id_pedido','pedidos.id')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')   
        ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')             
        ->select('municipios.nombre as municipio','departamentos.nombre as departamento','pedidos.*','pedidos_puntos.estado as estado_detalle','pedidos.estado as estado_pedido',
        'pedidos_puntos.id_repartidor as id_repartidor_pedido_punto','direcciones_clientes.nombre','direcciones_clientes.telefono',
        'direcciones_clientes.dui','pedidos.id as id_pedido','pedidos_puntos.id as id_pedido_punto','pedidos_puntos.id_punto','pedidos_puntos.show_pedido as show_pedido_punto_pedido')
        ->where([
            ['pedidos_puntos.estado',1],
            ['pedidos_puntos.show_pedido',1],
            ['pedidos_puntos.id_punto',$zoneUser->id_punto_reparto],     
                   
        ])->whereNull('pedidos.negocio')->get();
        

        return view('admin.pedidos-puntos-repartos')->with('allp',$allPedidos)->with('zona',$zoneUser->punto_reparto)->with('type','para reasignación');

    }


    public function IndexPedidosPuntoRecibido()
    {
        $zoneUser = DetallePuntoReparto::join('puntos_repartos','puntos_repartos.id','=','detalles_puntos_repartos.id_punto_reparto')
        ->join('users','users.id','=','detalles_puntos_repartos.id_usuario')->join('municipios','municipios.id','=','puntos_repartos.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('detalles_puntos_repartos.id_usuario',Auth::user()->id)
        ->select('municipios.id as municipio','departamentos.id as departamento','departamentos.nombre as departamento_nombre',
        'detalles_puntos_repartos.id_punto_reparto','puntos_repartos.nombre as punto_reparto')->first();


        $allPedidos = Pedido::join('pedidos_puntos','pedidos_puntos.id_pedido','pedidos.id')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')   
        ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')             
        ->select('municipios.nombre as municipio','departamentos.nombre as departamento','pedidos.*','pedidos_puntos.estado as estado_detalle','pedidos.estado as estado_pedido',
        'pedidos_puntos.id_repartidor as id_repartidor_pedido_punto','direcciones_clientes.nombre','direcciones_clientes.telefono',
        'direcciones_clientes.dui','pedidos.id as id_pedido','pedidos_puntos.id as id_pedido_punto','pedidos_puntos.id_punto','pedidos_puntos.show_pedido as show_pedido_punto_pedido')
        ->where([
            ['pedidos_puntos.estado',1],
            ['pedidos_puntos.show_pedido',0],
            ['pedidos_puntos.id_punto',$zoneUser->id_punto_reparto],            
        ])->whereNull('pedidos.negocio')->get();
        

        return view('admin.pedidos-puntos-repartos')->with('allp',$allPedidos)->with('zona',$zoneUser->punto_reparto)->with('type','recibidos');

    }



    public function IndexPedidosPuntoEntregado()
    {
        $zoneUser = DetallePuntoReparto::join('puntos_repartos','puntos_repartos.id','=','detalles_puntos_repartos.id_punto_reparto')
        ->join('users','users.id','=','detalles_puntos_repartos.id_usuario')->join('municipios','municipios.id','=','puntos_repartos.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('detalles_puntos_repartos.id_usuario',Auth::user()->id)
        ->select('municipios.id as municipio','departamentos.id as departamento','departamentos.nombre as departamento_nombre',
        'detalles_puntos_repartos.id_punto_reparto','puntos_repartos.nombre as punto_reparto')->first();


        $allPedidos = Pedido::join('pedidos_puntos','pedidos_puntos.id_pedido','pedidos.id')
        ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')   
        ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')             
        ->select('municipios.nombre as municipio','departamentos.nombre as departamento','pedidos.*','pedidos_puntos.estado as estado_detalle','pedidos.estado as estado_pedido',
        'pedidos_puntos.id_repartidor as id_repartidor_pedido_punto','direcciones_clientes.nombre','direcciones_clientes.telefono',
        'direcciones_clientes.dui','pedidos.id as id_pedido','pedidos_puntos.id as id_pedido_punto','pedidos_puntos.id_punto','pedidos_puntos.show_pedido as show_pedido_punto_pedido')
        ->where([
            ['pedidos_puntos.estado',2],            
            ['pedidos_puntos.id_punto',$zoneUser->id_punto_reparto],            
        ])->whereNull('pedidos.negocio')->get();
        

        return view('admin.pedidos-puntos-repartos')->with('allp',$allPedidos)->with('zona',$zoneUser->punto_reparto)->with('type','entregados');

    }



    public function indexComercios()
    {
        $comercios = Comercio::leftJoin('users','users.id','=','comercios.id_usuario')
        ->select('users.name as encargado','users.email as correo','comercios.*')->get();

        return view('admin.comercios')->with('comercios',$comercios);
    }

    public function indexZonasReparto()
    {
        $zonas = Zona::join('municipios','municipios.id','=','zonas.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->select('departamentos.id as id_departamento','departamentos.nombre as departamento','municipios.id as id_municipio','municipios.nombre as municipio','zonas.*')
        ->get();

        return view('admin.zonas-repartos')->with('zonas',$zonas);
    }




    public function indexPedidosComerciosForAdmin()
    {
       $pedidos = Pedido::join('pedidos_comercios','pedidos_comercios.id_pedido','=','pedidos.id')
       ->join('comercios','pedidos_comercios.id_comercio','=','comercios.id')
       ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')
       ->where('pedidos.negocio',1)
       ->select('comercios.nombre as comercio','pedidos.*','direcciones_clientes.nombre','direcciones_clientes.telefono')->get();


       return view('admin.pedidos-comercios')->with('pedidos', $pedidos);
    }


}
