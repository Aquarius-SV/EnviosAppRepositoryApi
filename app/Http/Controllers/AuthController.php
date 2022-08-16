<?php

namespace App\Http\Controllers;

use App\Models\{User,DetalleZona,Repartidor,DatoVehiculo,CodigoVerificacion};
/* use App\Models\Repartidor; */
/* use App\Models\DetalleZona; */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailApi;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'telefono' => 'required|string|min:8|max:12',
            'dui' => 'required|string|min:9|max:10',
            'nit' => 'required|string|min:9|max:10',
            'licencia' => 'required|string|min:17|max:17',
            'zonas' => 'required|array',
            'placa' => 'required|string|min:6|max:7',
            'modelo' => 'required|string|min:3|max:45',
            'marca' => 'required|string|min:4|max:45',
            'color' => 'required|string|min:4|max:45',
            'tipo' => 'required|string|min:4|max:45',
            'peso' => 'required',
            'size' => 'required',
        ]);

        try {
            // Comienza transaccion
            DB::beginTransaction();

            
    
            // Primero Registramos el usuario
            /* $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]); */
    
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->id_tipo_usuario = 3;
            $user->saveOrFail();

            // Registramos sus datos Personales
    
            $repartidor = new Repartidor;
            $repartidor->telefono = $request->telefono;
            $repartidor->dui = $request->dui;
            $repartidor->nit = $request->nit;
            $repartidor->licencia = $request->licencia;
            $repartidor->id_usuario = $user->id;
            $repartidor->saveOrFail();

            // Registro de datos de vehiculo
            $vehiculo = new DatoVehiculo();
            $vehiculo->tipo = $request->tipo;
            $vehiculo->placa = $request->placa;
            $vehiculo->modelo = $request->modelo;
            $vehiculo->marca = $request->marca;
            $vehiculo->color = $request->color;
            $vehiculo->id_user = $user->id;
            $vehiculo->peso = $request->peso;
            $vehiculo->size = $request->size;
            $vehiculo->saveOrFail();

            // Registramos las zonas de desplazo del repartidor
            
            foreach ($request->zonas as $value) {
                foreach ($value as $key => $v) {
                    if ($key === 'value') {
                        $zonas = new DetalleZona;
                        $zonas->id_zona = $v;
                        $zonas->id_repartidor = $repartidor->id;
                        $zonas->saveOrFail();
                    }
                }
            }
            
            DB::commit();
            
            $url = URL::signedRoute(
                'verificate.email',
                ['user' => $request->email]
            );
        
            Mail::to($request->email)->send(new SendMailApi($request->email, $url));

            return response()->json([
                'message' => 'Usuario registrado, confirme su correo electrónico'
            ], 201);            

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
            
        $user = $request->user();

        $estado = DB::table('repartidores')->where('id_usuario', $user->id)->value('estado');
        if (!$estado) {
            return response()->json([
                'message' => 'Usuario eliminado'
            ], 401);
        }
        
        $validate = $user->email_verified_at;

        if (!$validate) {
            return response()->json([
                'message' => 'Verifique su cuenta para continuar'
            ], 403);
        }
        $tokenResult = $user->createToken('email');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $id_repartidor = $user->repartidor;

        $zonas = $id_repartidor->areas;

        foreach ($zonas as $z) {
            $z->zona;
        }

        /* $id_repartidor = DetalleZona::join('conductores', 'detalles_zonas.id_repartidor', '=', 'conductores.id')->join('zonas', 'detalles_zonas.id_zona', '=', 'zonas.id')->where('conductores.id_usuario', $user->id)
        ->select('zonas.nombre as zona', 'conductores.telefono', 'conductores.dui', 'conductores.nit', 'conductores.licencia')->get(); */

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString(),
            'email' => $user->email,
            'id' => $user->id,
            'name' => $user->name,
            'conductor' => $id_repartidor,
            /* 'areas' => $zonas, */
        ]);
    }

    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /* 
        Validacion de los datos del usuario
    */
    
    public function realTimeValidation(Request $request) 
    {
        $data = $request->validate([
            'email' => 'string|email|unique:users',
            'password' => 'string',            
        ]);

        return $data;
    }

    // Almacenar expo token
    public function expoToken(Request $request)
    {

    }
}
