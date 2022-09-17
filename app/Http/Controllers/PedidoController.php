<?php

namespace App\Http\Controllers;

use App\Models\{Pedido, PedidoPunto, CambioPedido};
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use App\Models\ExpoNotification;
use App\Mail\{ClientTrouble, ClientTroubleRepeat};
use DB;

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
        try {
            $data = [];
        
            $pedidos = Pedido::join('repartidores', 'pedidos.id_repartidor', '=', 'repartidores.id')->join('users', 'pedidos.id_usuario', '=', 'users.id')
            ->leftJoin('pedidos_puntos', 'pedidos_puntos.id_pedido', '=', 'pedidos.id')
            ->join('direcciones_clientes', 'pedidos.id_dato_cliente', '=', 'direcciones_clientes.id')->where([
                ['repartidores.id', $id],
                ['pedidos.estado', 0]
            ])->select('pedidos.*', 'users.name', 'direcciones_clientes.nombre as nombre_cliente', 'direcciones_clientes.telefono as tel_cliente', 'pedidos_puntos.id as ext_id', 'pedidos.id as pp_id')->orderBy('pedidos.id', 'desc')->get();
            
            $pedidosExt = PedidoPunto::join('repartidores', 'pedidos_puntos.id_repartidor', '=', 'repartidores.id')->join('pedidos', 'pedidos_puntos.id_pedido', '=', 'pedidos.id')
            ->join('puntos_repartos', 'pedidos_puntos.id_punto', '=', 'puntos_repartos.id')->leftJoin('puntos_repartos as ptn_null', 'pedidos_puntos.id_punto_pedido', '=', 'ptn_null.id')
            ->join('direcciones_clientes', 'pedidos.id_dato_cliente', '=', 'direcciones_clientes.id')
            ->where([
                ['repartidores.id', $id],
                ['pedidos_puntos.estado', 3]
            ])
            ->select(DB::raw("CONCAT('altura: ', pedidos.alto, ', ', 'anchura: ', pedidos.ancho, ', ', 'profundidad: ', pedidos.profundidad) as size"),'pedidos_puntos.id_repartidor', 
            'puntos_repartos.*', 'pedidos_puntos.id as id_pedido', 'pedidos_puntos.created_at as fecha', 'pedidos.envio', 'pedidos.sku', 'pedidos.peso', 'pedidos.fragil', 'ptn_null.direccion as ptn_null', 
            'ptn_null.telefono as tlfn', 'direcciones_clientes.nombre as nombre_cliente', 'direcciones_clientes.telefono as tel_cliente', 'pedidos_puntos.id_punto_pedido as id_from', 'pedidos_puntos.id as ext_id', 'pedidos.id as pp_id')
            ->orderBy('pedidos_puntos.id', 'desc')->get();

            $data = [
                'pedidos' => $pedidos,
                'pedidosExt' => $pedidosExt,
            ];
            
            return $data;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
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
        if ($state == /* 3 */5)
        {
            $expo = ExpoNotification::where('id_user',$request->user('api')->id)->get();
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
        /* $pedidos = Pedido::join('repartidores', 'pedidos.id_repartidor', '=', 'repartidores.id')->join('users', 'pedidos.id_usuario', '=', 'users.id')->where([
            ['repartidores.id', $id],
            ['pedidos.estado', 4]
        ])->orWhere([['repartidores.id', $id],['pedidos.estado', 5]])->select('pedidos.*', 'users.name as title')->orderBy('pedidos.id', 'desc')->get(); */
        $firts = Pedido::where('estado', 5)->count();
        $second = Pedido::where('estado', 9)->count();

        $pedidos = Pedido::join('repartidores', 'pedidos.id_repartidor', '=', 'repartidores.id')->join('users', 'pedidos.id_usuario', '=', 'users.id')
        ->leftJoin('pedidos_puntos', 'pedidos_puntos.id_pedido', '=', 'pedidos.id')
        ->where([
            ['repartidores.id', $id],
            ['pedidos_puntos.estado', 0],
            ['pedidos.show_pedido', 1],            
        ])->whereIn('pedidos.estado', [5, 9])->select('pedidos.*' /* 'users.name as title' */, 'pedidos.sku as title', 'pedidos_puntos.id as ext_id', 'pedidos.id as pp_id')->orderBy('pedidos.id', 'desc')->get();
        
        // Pedidos externos 0
        $pedidosExt = PedidoPunto::join('repartidores', 'pedidos_puntos.id_repartidor', '=', 'repartidores.id')->join('pedidos', 'pedidos_puntos.id_pedido', '=', 'pedidos.id')
            ->join('puntos_repartos', 'pedidos_puntos.id_punto', '=', 'puntos_repartos.id')->leftJoin('puntos_repartos as ptn_null', 'pedidos_puntos.id_punto_pedido', '=', 'ptn_null.id')
            ->join('direcciones_clientes', 'pedidos.id_dato_cliente', '=', 'direcciones_clientes.id')
            ->where([
                ['repartidores.id', $id],
                ['pedidos_puntos.estado', 0],                
                ['pedidos_puntos.show_pedido', 1],
            ])
            ->select(DB::raw("CONCAT('altura: ', pedidos.alto, ', ', 'anchura: ', pedidos.ancho, ', ', 'profundidad: ', pedidos.profundidad) as size"),'pedidos_puntos.id_repartidor', 
            'puntos_repartos.*', 'pedidos_puntos.id as id_pedido', 'pedidos_puntos.created_at as fecha', 'pedidos.envio', 'pedidos.sku', 'pedidos.peso', 'pedidos.fragil', 'ptn_null.direccion as ptn_null', 
            'ptn_null.telefono as tlfn', 'direcciones_clientes.nombre as nombre_cliente', 'direcciones_clientes.telefono as tel_cliente', 'pedidos_puntos.id_punto_pedido as id_from', 
            'pedidos_puntos.id as ext_id', 'pedidos.id as pp_id', 'pedidos.sku as title', 'pedidos_puntos.estado as pp_estado', 'pedidos.id', 'pedidos.estado')
            ->orderBy('pedidos_puntos.id', 'desc')->get();

        $array = [
            'pedidos' => $pedidos,
            'pedidosExt' => $pedidosExt
        ];

        return $array;
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

    public function trackPoint($municipio)
    {
        try {
            $data = \DB::table('puntos_repartos')->where('id_municipio', $municipio)->select(DB::raw("CONCAT(nombre, ' - ', direccion) AS label"), 'id')->get();
            return $data;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    }

    public function storePoint(Request $request, $pedido, $punto)
    {
        try {
            DB::transaction(function () use($request, $pedido, $punto) {
                $direccion = $request->direccion;
                
                $lastId = PedidoPunto::latest()->value('id');

                PedidoPunto::create([
                    'id_pedido' => $pedido,
                    'id_punto' => $punto,
                    'id_punto_pedido' => $lastId+1
                ]);
                
                Pedido::where('id', $pedido)->update(['estado' => 9, 'direccion_entrega' => $direccion]);

                $expo = ExpoNotification::where('id_user',$request->user('api')->id)->get();
                $messages = [           
                new ExpoMessage([
                    'title' => 'Actualización de pedido',
                    'body' => 'Pedido aceptado correctamente',
                ]),];
                foreach ($expo as $ex ) {
                    (new Expo)->send($messages)->to([$ex->expo_token])->push();
                }

                return response()->json(['message' => 'Data storage.',], 200);
            });            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    }

    /**
     * Devolution packages get
    **/

    public function returnPackages($id, Request $request)
    {
        try {
            $pedidosExt = PedidoPunto::join('repartidores', 'pedidos_puntos.id_repartidor', '=', 'repartidores.id')->join('pedidos', 'pedidos_puntos.id_pedido', '=', 'pedidos.id')
            ->join('puntos_repartos', 'pedidos_puntos.id_punto', '=', 'puntos_repartos.id')->leftJoin('puntos_repartos as ptn_null', 'pedidos_puntos.id_punto_pedido', '=', 'ptn_null.id')
            ->join('direcciones_clientes', 'pedidos.id_dato_cliente', '=', 'direcciones_clientes.id')
            ->where([
                ['repartidores.id', $id],
                ['pedidos_puntos.estado', 4],
                ['pedidos.estado', ],
            ])
            ->select(DB::raw("CONCAT('altura: ', pedidos.alto, ', ', 'anchura: ', pedidos.ancho, ', ', 'profundidad: ', pedidos.profundidad) as size"),'pedidos_puntos.id_repartidor', 
            'puntos_repartos.*', 'pedidos_puntos.id as id_pedido', 'pedidos_puntos.created_at as fecha', 'pedidos.envio', 'pedidos.sku', 'pedidos.peso', 'pedidos.fragil', 'ptn_null.direccion as ptn_null', 
            'ptn_null.telefono as tlfn', 'direcciones_clientes.nombre as nombre_cliente', 'direcciones_clientes.telefono as tel_cliente')
            ->orderBy('pedidos_puntos.id', 'desc')->get();

            return $pedidosExt;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    }

    public function ifId(Request $request, $id, $idP, $idPP)
    {
        try {
            DB::transaction(function () use($request, $id, $idP, $idPP) {            
                PedidoPunto::where('id', $id)->update([
                    'estado' => 0,                    
                ]);

                PedidoPunto::where('id', $idP)->update([
                    'estado' => 0,
                    'show_pedido' => 0
                ]);

                Pedido::where('id', $idPP)->update([
                    'show_pedido' => 0
                ]);

                $expo = ExpoNotification::where('id_user',$request->user('api')->id)->get();
                $messages = [           
                    new ExpoMessage([
                        'title' => 'Actualización de pedido',
                        'body' => 'Pedido aceptado correctamente',
                ]),];
                foreach ($expo as $ex ) {
                    (new Expo)->send($messages)->to([$ex->expo_token])->push();
                }
            });
            return response()->json(['message' => 'Data storage.',], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    }

    public function noId(Request $request)
    {
        try {
            DB::transaction(function () use($request) {
                Pedido::where('id', $request->id)->update(['estado' => 5]);
                PedidoPunto::where('id', $request->id_ext)->update(['estado' => 0]);

                $expo = ExpoNotification::where('id_user',$request->user('api')->id)->get();
                $messages = [           
                    new ExpoMessage([
                        'title' => 'Actualización de pedido',
                        'body' => 'Pedido aceptado correctamente',
                ]),];
                foreach ($expo as $ex ) {
                    (new Expo)->send($messages)->to([$ex->expo_token])->push();
                }
            });
            return response()->json(['message' => 'Data storage.',], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    }

    public function finishState(Request $request)
    {
        try {
            DB::transaction(function () use($request) {
                $state = $request->state;
                $newState = $request->newState;
                $newStateT = $request->newStateT;

                if ($state == 9 || $state == 5) {
                    Pedido::where('id', $request->id)->update(['estado' => $newState]);
                    PedidoPunto::where('id', $request->ext_id)->update(['estado' => $newStateT]);
                } else {
                    if ($request->id_punto_pedido) {
                        Pedido::where('id', $request->id)->update(['estado' => 10]);
                        PedidoPunto::where('id', $request->ext_id)->update(['estado' => 1]);
                        PedidoPunto::where('id', $request->id_punto_pedido)->update(['estado' => 2]);
                    }
                }
            });
            return response()->json(['message' => 'Data storage.',], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    }

    public function clientProblem($email, $pedido)
    {
        try {
            $cambios = CambioPedido::where([
                ['id_pedido', $pedido],
                ['fecha', '!=', null],
                ['turno', '!=', null],
            ])->first();
            
            if (!$cambios) {
                \Mail::to($email)->send(new ClientTrouble($email, $pedido));
            } else {
                \Mail::to($email)->send(new ClientTroubleRepeat());              
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),], 500);
        }
    }
}
