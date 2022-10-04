<?php

namespace App\Http\Livewire\Intermediario;

use Livewire\Component;
use App\Models\{Departamento,Municipio,Pedido,Zona,Repartidor,PedidoPunto,PuntoReparto,LogChangePedido,User};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\ExpoNotification;
use App\Mail\StatusPedido;
use App\Notifications\StatePedido;
use Illuminate\Support\Facades\Mail;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use DB;
use Illuminate\Support\Facades\URL;

class AsignarPedido extends Component
{
    use LivewireAlert;

    public $pedido_punto,$pedido,$departamento,$municipio,$zona,$departamento_punto,$municipio_punto,$entrega,$punto,$repartidor;
    public $departamentos = [],$municipios = [],$zonas=[],$repartidores=[],$municipios_puntos = [],$zonaPuntos = [];
    public $nombrePunto,$puntoRepartoCreator;

    protected $rules = [
        'entrega' => 'required',
        'departamento_punto' => 'required_if:entrega,Punto',
        'municipio_punto' => 'required_if:entrega,Punto',
        'punto' => 'required_if:entrega,Punto',

        'departamento' => 'required',
        'municipio' => 'required',
        'zona' => 'required',
        'repartidor' => 'required',
    ];

    protected $messages = [
        'entrega.required' => 'Punto de entrega es obligatorio',
        'departamento_punto.required_if' => 'Departamento es obligatorio',
        'municipio_punto.required_if' => 'Municipio es obligatorio',
        'punto.required_if' => 'Punto de reparto es obligatorio',

        'departamento.required' => 'Departamento es obligatorio',
        'municipio.required' => 'Municipio es obligatorio',
        'zona.required' => 'Zona es obligatorio',
        'repartidor.required' => 'Repartidor es obligatorio'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    protected $listeners = [
        'assignPedido',
        'redirectToRoute',
        'assignRepartidor'
    ];

    public function assignPedido($pedido)
    {
        $this->pedido = $pedido['id_pedido'];
        $this->pedido_punto = $pedido['id_pedido_punto'];
        $this->puntoRepartoCreator = $pedido['id_punto'];

    }

    public function redirectToRoute()
    {
        $url = url()->previous();
        return redirect($url);
    }

    public function assignRepartidor($pedido)
    {
        $this->id_pedido = $pedido;
    }

    public function savePedido()
    {
        try {
            $pedido = new PedidoPunto;
            $pedido->id_pedido = $pedido;
            /* $pedido->id_punto = $this->puntoRepartoCreator; */
            $pedido->id_repartidor = $this->repartidor;
            $pedido->show_pedido = 0 ;
            $pedido->estado = 3;               
            $pedido->save();

            $repartidorEmail = Repartidor::join('users','users.id','=','repartidores.id_usuario')->where('repartidores.id',$this->repartidor)->select('users.email','users.id')->first();
            $userNotification = User::where('id',$repartidorEmail->id)->select('users.*')->get();
            $expo = ExpoNotification::where('id_user',$repartidorEmail->id)->get();
            $numero =$pedido;
            $state = 'El pedido No '.$numero.' se te a asignado. Entra a la aplicación para aceptar o denegar el pedido';
            $to = $repartidorEmail->email;
                    
            Pedido::emailToUsersPedido($to,$numero,$state);

            $data = [                
                'concepto' => $state
            ];
            
            Notification::send($userNotification , new StatePedido($data));                       
            
            //EXPO
            $messages = [           
            new ExpoMessage([
                'title' => 'Asignación de pedido',
                'body' => $state,
            ]),];
            foreach ($expo as $ex ) {
                (new Expo)->send($messages)->to([$ex->expo_token])->push();
            }

            $this->alert('success', 'Pedido asignado con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectToRoute',
                'confirmButtonText' => 'Entendido',
               ]);
    } catch (\Throwable $th) {
        $this->alert('error', $th->getMessage(), [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Entendido',
           ]);
    }
    }


    public function reassignPedido()
    {
        $this->validate();
        try {
            DB::beginTransaction();

            

            if ($this->entrega == 'Punto') {
               
                $direccionEntrega = PuntoReparto::where('id',$this->punto)->value('direccion');
                $direccionRecogida = PuntoReparto::where('id',$this->puntoRepartoCreator)->value('direccion');
                
                $pedido = new PedidoPunto;
                $pedido->id_pedido = $this->pedido;
                $pedido->id_punto = $this->punto;
                $pedido->id_repartidor = $this->repartidor;
                $pedido->estado = 3;
                $pedido->id_punto_pedido = $this->pedido_punto;
                $pedido->save();
                PedidoPunto::where('id',$this->pedido_punto)->update([
                    'estado' => 3,                    
                ]);

                Pedido::where('id',$this->pedido)->update([
                    'estado' => 9,
                    'direccion_entrega' => $direccionEntrega,
                    'direccion_recogida' => $direccionRecogida
                ]);


                $nombrePuntoEntrega = PuntoReparto::where('id',$this->punto)->value('nombre');


                $log = new LogChangePedido;
                $log->id_pedido = $this->pedido;
                $log->id_repartidor = $this->repartidor;
                $log->id_zona = $this->zona;
                $log->accion = 'Pedido reasignado desde punto de reparto: '.$this->nombrePunto.' hacia el punto de reparto: '.$nombrePuntoEntrega;
                $log->save();


                $repartidorEmail = Repartidor::join('users','users.id','=','repartidores.id_usuario')->where('repartidores.id',$this->repartidor)->select('users.email','users.id')->first();
                $userNotification = User::where('id',$repartidorEmail->id)->select('users.*')->get();
                $expo = ExpoNotification::where('id_user',$repartidorEmail->id)->get();
                $numero =$this->pedido_punto;
                $state = 'El pedido No '.$numero.' se te a asignado. Entra a la aplicación para aceptar o denegar el pedido';
                $to = $repartidorEmail->email;
                        
                Pedido::emailToUsersPedido($to,$numero,$state);

                $data = [                
                    'concepto' => $state
                ];
                
                Notification::send($userNotification , new StatePedido($data));                       
                
                //EXPO
                $messages = [           
                new ExpoMessage([
                    'title' => 'Asignación de pedido',
                    'body' => $state,
                ]),];
                foreach ($expo as $ex ) {
                    (new Expo)->send($messages)->to([$ex->expo_token])->push();
                }


            }else{

                $direccionEntrega = Pedido::join('direcciones_clientes','direcciones_clientes.id','=', 'pedidos.id_dato_cliente')
                ->where('pedidos.id',$this->pedido)->value('direcciones_clientes.direccion');
                $direccionRecogida = PuntoReparto::where('id',$this->puntoRepartoCreator)->value('direccion');

                $pedido = new PedidoPunto;
                $pedido->id_pedido = $this->pedido;
                $pedido->id_punto = $this->puntoRepartoCreator;
                $pedido->id_repartidor = $this->repartidor;                
                $pedido->estado = 3;               
                $pedido->save();

                PedidoPunto::where('id',$this->pedido_punto)->update([
                    'estado' => 1,
                    'show_pedido' => 0                    
                ]);
                Pedido::where('id',$this->pedido)->update([
                    'estado' => 5,
                    'direccion_recogida' => $direccionRecogida,
                    'direccion_entrega' => $direccionEntrega,
                    'show_pedido' =>0
                ]);
                $log = new LogChangePedido;
                $log->id_pedido = $this->pedido;
                $log->id_repartidor = $this->repartidor;
                $log->id_zona = $this->zona;
                $log->accion = 'Pedido reasignado desde punto de reparto hacía el cliente final.';
                $log->save();


                $repartidorEmail = Repartidor::join('users','users.id','=','repartidores.id_usuario')->where('repartidores.id',$this->repartidor)->select('users.email','users.id')->first();
                $userNotification = User::where('id',$repartidorEmail->id)->select('users.*')->get();
                $expo = ExpoNotification::where('id_user',$repartidorEmail->id)->get();
                $numero =$this->pedido_punto;
                $state = 'El pedido No '.$numero.' se te a asignado. Entra a la aplicación para aceptar o denegar el pedido';
                $to = $repartidorEmail->email;
                        
                Pedido::emailToUsersPedido($to,$numero,$state);

                $data = [                
                    'concepto' => $state
                ];
                
                Notification::send($userNotification , new StatePedido($data));                       
                
                //EXPO
                $messages = [           
                new ExpoMessage([
                    'title' => 'Asignación de pedido',
                    'body' => $state,
                ]),];
                foreach ($expo as $ex ) {
                    (new Expo)->send($messages)->to([$ex->expo_token])->push();
                }



            }           
            DB::commit();
            $this->alert('success', 'Pedido asignado con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectToRoute',
                'confirmButtonText' => 'Entendido',
               ]);
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage(), [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
               ]);
            DB::rollBack();
        }
    }



    public function render()
    {
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }
        if ($this->municipio) {
            $this->zonas = Zona::where([
                ['estado',1],
                ['id_municipio',$this->municipio]
            ])->select('nombre','id as id_zone')->get();   
        }                
        if ($this->zona) {
            $this->repartidores = Repartidor::join('users','users.id','=','repartidores.id_usuario')->join('detalles_zonas','detalles_zonas.id_repartidor','=','repartidores.id')
            ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')
            ->where('repartidores.estado',1)->where('detalles_zonas.id_zona',$this->zona)
            ->select('users.name as nombre','repartidores.telefono','repartidores.id as id_repartidor','datos_vehiculos.tipo as tipo_vehiculo','datos_vehiculos.marca','datos_vehiculos.modelo',
            'datos_vehiculos.peso','datos_vehiculos.size')->get();     
        }  
      

        if ($this->departamento_punto) {
            $this->municipios_puntos = Municipio::where('id_departamento',$this->departamento_punto)->get();
         }
 
         if ($this->municipio_punto) {           
            $this->zonaPuntos = PuntoReparto::where('id_municipio',$this->municipio_punto)->get();
         }
        
        return view('livewire.intermediario.asignar-pedido');
    }
}
