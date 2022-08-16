<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Zona;
use App\Models\Repartidor;
use App\Models\Municipio;
use Illuminate\Support\Facades\Auth;
use App\Mail\StatusPedido;
use Illuminate\Support\Facades\Mail;
use App\Notifications\StatePedido;
use Illuminate\Support\Facades\Notification;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use App\Models\ExpoNotification;



class PedidoApiController extends Controller
{
    public function index(Request $request,  $id)
    {
       //Funcion que devuelve un array con el listado de pedidos del negocio en especifico
       $user = User::where('id',$id)->select('users.*')->first();
       if ($user !== null) {
        if ($request->token === $user->remember_token && $request->type_token === 'Bearer') {
        
            $allPedidos = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')->join('users','users.id','=','repartidores.id_usuario')
            ->select('pedidos.*','users.name as repartidor')
            ->where('pedidos.id_usuario',$id)->whereNotNull('pedidos.id_api_venta')->get();
            return $allPedidos;
            }else {                 
              return response()->json(['message' => 'Unauthorized'], 401);              
            }
       }else {
            return response()->json(['message' => 'Error'], 500);
       }              
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
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('Personal Access Token')->accessToken;
            User::where('email', $request->email)->update([
                'remember_token' => $token
            ]);
            return response()->json([
                'message' => 'login success',  
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user_id' => $user->id
            ]);
        }
   }

   public function logoutUser($email)
   {              
       try {
        User::where('email',$email)->update([
            'remember_token' => null
        ]);
        Auth::logout();       
        return response()->json([
            'message' => 'sesion cerrada.'
        ]);
       } catch (\Throwable $th) {
        return response()->json([
            'message' => $th->getMessage(),              
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

        $municipio = Municipio::where('nombre',$request->municipio)->value('id') ;
        $user = User::where('id',$request->id_user_api)->select('users.*')->first();

        if ($request->token === $user->remember_token && $request->type_token === 'Bearer') {
           
            try {
                $pedido = new Pedido;
                $pedido->direccion_recogida = $request->direccion_recogida;
                $pedido->direccion_entrega = $request->direccion_entrega;
                $pedido->id_api_venta = $request->id_api_venta;
                $pedido->id_repartidor = $request->id_repartidor;
                $pedido->id_usuario = $request->id_user_api;
                $pedido->tel_cliente = $request->tel_cliente;
                $pedido->peso = $request->peso;                
                $pedido->alto = $request->alto;
                $pedido->ancho = $request->ancho;
                $pedido->fragil = $request->fragil;
                $pedido->tipo_embalaje = $request->embalaje;
                $pedido->nombre_cliente = $request->cliente;
                $pedido->negocio = $request->negocio;
                $pedido->profundidad = $request->profundidad;
                $pedido->referencia = $request->referencia;
                $pedido->envio = $request->envio;
                $pedido->id_municipio = $municipio;
                $pedido->dui = $request->dui;
                $pedido->save();
                $reparidorEmail = Repartidor::join('users','users.id','=','repartidores.id_usuario')->where('repartidores.id',$request->id_repartidor)->select('users.*')->first();
                $numero = $pedido->id;
                $state = 'El pedido No '.$numero.' se te a asignado. Entra a tu aplicación para aceptar o denegar el pedido';
                $to = $reparidorEmail->email;             
                $userNotification = User::where('id',$reparidorEmail->id)->select('users.*')->get();
                $expo = ExpoNotification::where('id_user',$reparidorEmail->id)->get();
                
                
                $data = [                
                    'concepto' => $state
                ];
                Pedido::emailToUsersPedido($to,$numero,$state);
                Notification::send($userNotification , new StatePedido($data));   
                //EXPO
                $messages = [           
                new ExpoMessage([
                    'title' => 'Nuevo pedido disponible',
                    'body' => $state,
                ]),];
                foreach ($expo as $ex ) {
                    (new Expo)->send($messages)->to([$ex->expo_token])->push();
                }                               
                return response()->json([
                 'message' => 'ok'
                ]);
            } catch (\Throwable $th) {
             return response()->json([
                 'message' => $th->getMessage(),              
             ]);
            }
        }else {
          
            return response()->json(['message' => 'Unauthorized'], 401);
        }       
   }



   public function updatePedido(Request $request,$id)
   {    

        $user = User::where('id',$request->id_user_api)->select('users.*')->first();

        if ($request->token === $user->remember_token && $request->type_token === 'Bearer') {

            try {
                Pedido::where('id',$id)->update([
                    'direccion_recogida' => $request->direccion_recogida,
                    'tel_cliente' => $request->tel_cliente,
                    'peso' => $request->peso,
                    'ancho' => $request->ancho,
                    'alto' => $request->alto,
                    'tipo_embalaje' => $request->embalaje,
                    'fragil' => $request->fragil,
                    'profundidad' => $request->profundidad,
                    'envio' => $request->envio,
                ]);
                return response()->json([
                    'message' => 'ok',              
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => $th->getMessage(),              
                ]);
            }
        }else {
            
            return response()->json(['message' => 'Unauthorized'], 401);
        }  
   }


   public function updateRepartidor(Request $request,$id)
   {
        $user = User::where('id',$request->id_user_api)->select('users.*')->first();

        if ($request->token === $user->remember_token && $request->type_token === 'Bearer') {

            try {
                Pedido::where('id',$id)->update([
                    'id_repartidor' => $request->repartidor,
                    'estado' => 0
                ]);
                $numero = $id;
                $state = 'El pedido No '.$numero.' se te a asignado. Entra a tu aplicación para aceptar o denegar el pedido';
                $to = 'diegouriel.martinez15@gmail.com';
                /*falta poner esto en el to del email repartidor  $repartdorEmail->email*/
               Pedido::emailToUsersPedido($to,$numero,$state);
                return response()->json([
                    'message' => 'ok',              
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Error',              
                ]);
            }
        }else {
                
            return response()->json(['message' => 'Unauthorized'], 401);
        } 

   }


   public function statePreparacion(Request $request,$id)
   {
     $user = User::where('id',$request->id_user_api)->select('users.*')->first();

     if ($request->token === $user->remember_token && $request->type_token === 'Bearer') {

       try {        
            Pedido::where('id',$id)->update([
                'estado' => 2
            ]);
            $repartdorEmail = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')
            ->join('users','users.id','=','repartidores.id_usuario')->where('pedidos.id',$id)->select('users.email','users.id','users.remember_token')->get();
            $userNotification = User::where('id',$repartdorEmail[0]->id)->select('users.*')->get();
            $expo = ExpoNotification::where('id_user',$repartdorEmail[0]->id)->get();
            $numero = $id;
            $state = 'El pedido No '.$id.' esta disponible siendo preparado';
            $to = 'diegouriel.martinez15@gmail.com';
            
            
            Pedido::emailToUsersPedido($to,$numero,$state);
            //Mail::to('diegouriel.martinez15@gmail.com')->send(new StatusPedido($numero,$state));
            $data = [                
                'concepto' => $state
            ];
            
            Notification::send($userNotification , new StatePedido($data));   
           //EXPO
           $messages = [           
            new ExpoMessage([
                'title' => 'Actualización de pedido',
                'body' => $state,
            ]),];
            foreach ($expo as $ex ) {
                (new Expo)->send($messages)->to([$ex->expo_token])->push();
            }
            return response()->json([
                'message' => 'ok',              
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),              
            ]);
        }
     }else{                
        return response()->json(['message' => 'Unauthorized'], 401);
     } 

    
   }

   public function stateRecoger(Request $request,$id)
   {
        $user = User::where('id',$request->id_user_api)->select('users.*')->first();

        if ($request->token === $user->remember_token && $request->type_token === 'Bearer') {

            try {
                Pedido::where('id',$id)->update([
                    'estado' => 3,
                    'peso' => $request->peso,
                   
                ]);    
                $repartdorEmail = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')
                ->join('users','users.id','=','repartidores.id_usuario')->where('pedidos.id',$id)->select('users.email','users.id','users.remember_token')->get();
                $userNotification = User::where('id',$repartdorEmail[0]->id)->select('users.*')->get();
                $expo = ExpoNotification::where('id_user',$repartdorEmail[0]->id)->get();
                $numero = $id;
                $state = 'El pedido No '.$id.' esta disponible para recogida';
                $to = 'diegouriel.martinez15@gmail.com';
                
                
                Pedido::emailToUsersPedido($to,$numero,$state);
                $data = [                
                    'concepto' => $state
                ];            
                Notification::send($userNotification, new StatePedido($data));  

               //EXPO
               $messages = [           
                new ExpoMessage([
                    'title' => 'Actualización de pedido',
                    'body' => $state,
                ]),];
                foreach ($expo as $ex ) {
                    (new Expo)->send($messages)->to([$ex->expo_token])->push();
                }

                return response()->json([
                    'message' => 'ok',              
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'message' => 'Error',              
                ]);
            }
        } else {                
            return response()->json(['message' => 'Unauthorized'], 401);
        }     
   }
   


   public function checkStatePedidoClient($id)
   {
        $pedido = Pedido::where('id_api_venta',$id)->select('pedidos.estado as state')->get();
        return response()->json([
            'state' => $pedido,              
        ]);
   }
}
