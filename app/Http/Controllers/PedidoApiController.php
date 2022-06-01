<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Zona;
use App\Models\Repartidor;
use Illuminate\Support\Facades\Auth;
class PedidoApiController extends Controller
{
    public function index(Request $request)
    {
       $allPedidos = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','pedidos.id_usuario')
       ->select('repartidores.id_usuario','repartidores.id as id_repartidor','pedidos.direccion_entrega','pedidos.direccion_recogida','pedidos.estado','pedidos.id as id_pedido')
       ->where('pedidos.id_usuario',$request->id)->get();

       return $allPedidos;
    }



   public function userLogin(Request $request)
   {
        $checkUser = User::where('email', '=', $request->email)->select('password')->first();

        if ($checkUser == null) {
            return response()->json([
                'message' => 'No hay registros con este correo electronico.'
            ]);
          

        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $login = Auth::attempt($credentials);
        
        if ($login == false) {
            return response()->json([
                'message' => 'La contraseña es incorrecta.'
            ]);
            
        }else {
            
            return response()->json([
                'message' => 'Inicio de sesion completado',              
            ]);
        }
   }


   public function logoutUser(Request $request)
   {
       try {
        Auth::logout();
        return response()->json([
            'message' => 'sesion cerradara.'
        ]);
       } catch (\Throwable $th) {
        return response()->json([
            'message' => 'ocurrio un error',              
        ]);
       }
   }

   public function deliveryZones($id)
   {
        $deliveries = Repartidor::join('users','users.id','=','repartidores.id_usuario')->join('detalles_zonas','detalles_zonas.id_repartidor','=','repartidores.id')
        ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')
        ->where('repartidores.estado',1)->where('detalles_zonas.id_zona',$id)
        ->select('users.name as nombre','repartidores.telefono','repartidores.id as id_repartidor','datos_vehiculos.tipo as tipo_vehiculo','datos_vehiculos.marca','datos_vehiculos.modelo',
        'datos_vehiculos.peso','datos_vehiculos.size')->get();     

        return $deliveries;
   }


   public function allZonesDelivery()
   {
        $zones = Zona::where('estado',1)->select('nombre','id as id_zone')->get();    

        return $zones;
   }


   public function storePedido(Request $request)
   {
       try {
           $pedido = new Pedido;
           $pedido->direccion_recogida = $request->direccion_recogida;
           $pedido->direccion_entrega = $request->direccion_entrega;
           $pedido->id_api_venta = $request->id_api_venta;
           $pedido->id_repartidor = $request->id_repartidor;
           $pedido->save();
           return response()->json([
            'message' => 'ok'
        ]);
       } catch (\Throwable $th) {
        return response()->json([
            'message' => $th->getMessage(),              
        ]);
       }
   }


}
