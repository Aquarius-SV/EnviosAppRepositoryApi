<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\{Zona,Repartidor,Pedido,User,Municipio,Departamento,
    Direccion,LogChangePedido,Comercio,PuntoReparto,
    DireccionClienteModel,PedidoPunto,PedidoComercio};
use Illuminate\Support\Facades\Notification;
use App\Models\ExpoNotification;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Mail\StatusPedido;
use App\Notifications\StatePedido;
use Illuminate\Support\Facades\Mail;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use DB;

class PedidoComponent extends Component
{

    use LivewireAlert;
    public $zones = [];
    public $departamentos = [];
    public $municipios = [];
    public $zoneSelected;
    public $deliveries = [];
    public $repartidor;
    public $tel_cliente,$cliente,$dui;        
    public $peso,$alto,$ancho,$profundidad,$embalaje,$fragil,$envio;
    public $direccion_recogida,$direccion_entrega,$referencia;
    public $municipio,$departamento,$tipo_zona,$direcciones = [];
    public $municipio_envio,$departamento_envio,$municipios_envios = [],$direcciones_clientes = [];

    public $step,$direccion_cliente;
    public $comercios = [],$puntos = [],$punto,$comercio,$contenido,$direcciones_defaults = [];
    public $opt,$cod_search,$pedido;


    public $listeners = ['reset'=>'resetInput','confirmed','asigPedido'=>'asingPedido','pagoQuestion','pedidoPagado'];


    protected $rules = [
        'direccion_recogida'=> 'required',
        'direccion_cliente'=> 'required',
        
        'repartidor' => 'required',
        'zoneSelected' => 'required',

        'peso' => 'required|numeric|min:0',
        'alto' => 'required|numeric|min:0',
        'ancho' => 'required|numeric|min:0',
        'profundidad' => 'required|numeric|min:0',

        'embalaje' => 'required',
        'fragil' => 'required',
        'envio' => 'required',

        'contenido' => 'required',

        'municipio' => 'required',
        'departamento' => 'required',    
        
        'punto' =>'required',
        'comercio' => 'required',
    ];

    protected $messages = [
        'direccion_recogida.required'=>'Dirección de recogida es obligatoria',
        'direccion_recogida.min'=>'Dirección de recogida debe contener un minimo de :min caracteres',

        'direccion_cliente.required'=>'Dirección del cliente es obligatoria',

        'comercio.required' => 'El comercio es obligatorio',
        'contenido.required'=>'La descripción del contenido es obligatoria',

        'repartidor.required'=>'Debes selecionar un repartidor',
        'zoneSelected.required'=>'Debes selecionar una zona de entrega',

        'peso.required'=>'El peso del paquete es obligatorio',
        'peso.numeric'=>'El peso únicamente admite datos numéricos',
        'peso.min'=>'El peso debe ser mayor a :min',
        
        'alto.required'=>'El alto del paquete es obligatorio',
        'alto.numeric'=>'El alto únicamente admite datos numéricos',
        'alto.min'=>'El alto debe ser mayor a :min',

        'ancho.required'=>'El ancho del paquete es obligatorio',
        'ancho.numeric'=>'El ancho únicamente admite datos numéricos',
        'ancho.min'=>'El ancho debe ser mayor a :min',

        'profundidad.required'=>'La profundidad del paquete es obligatorio',
        'profundidad.numeric'=>'La profundidad únicamente admite datos numéricos',
        'profundidad.min'=>'La profundidad debe ser mayor a :min',

        
        'embalaje.required'=>'Debes seleccioner el tipo de embalaje',
        'fragil.required'=>'Debes seleccionar si el paquete',
        'envio.required'=>'Debes seleccionar el tipo de envío',

        'punto.required' => 'El punto de reparto es obligatorio',

        'departamento.required'=>'Debes seleccionar el departamento',
        'municipio.required'=>'Debes seleccionar el municipio',                                
    ];

    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['repartidor','zoneSelected','direccion_recogida','direccion_entrega','tel_cliente',
        'peso','alto','ancho','profundidad','embalaje','fragil','envio','cliente','dui',
        'municipio','departamento','municipios','tipo_zona']);
    }
    
    public function confirmed()
    {
       return redirect('/administracion/creacion-pedidos');
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function asigPedido($pedido)
    {       
        $this->repartidor = $pedido['id_repartidor'];        
    }

    public function showNewDireccion()
    {
        if ($this->step == null) {
            $this->step  = 1;
        }else{
            $this->step  = null;
        }
        
    }

    public function searchDireccionCliente()
    {
        $this->direccion_cliente = User::join('direcciones_clientes','direcciones_clientes.id_usuario','=','users.id')
        ->join('municipios','municipios.id','=','direcciones_clientes.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where([
            ['direcciones_clientes.cod',$this->cod_search],
            ['direcciones_clientes.estado',1]
        ])->value('direcciones_clientes.id');
    }



    public function store()
    {
        $this->validate();  
        try {                                   
            DB::beginTransaction();
            
            $dataPunto = PuntoReparto::where('id',$this->punto)->select('direccion','codigo','id_municipio')->first();
            $pedidoCOunt = Pedido::select('id')->count();
            $codComercio = Comercio::where('id',$this->comercio)->value('cod');

            $pedido = new Pedido;
            $pedido->id_dato_cliente = $this->direccion_cliente;    
            $pedido->sku = $pedidoCOunt.$dataPunto->codigo.$codComercio;
            $pedido->direccion_entrega = $dataPunto->direccion;
            $pedido->direccion_recogida = $this->direccion_recogida;
            $pedido->id_usuario = Auth::user()->id;
            $pedido->id_repartidor = $this->repartidor;            
            $pedido->peso = $this->peso;            
            $pedido->fragil = $this->fragil;
            $pedido->alto = $this->alto;
            $pedido->ancho = $this->ancho;
            $pedido->profundidad = $this->profundidad;            
            $pedido->envio = $this->envio;
            $pedido->tipo_embalaje = $this->embalaje;       
            $pedido->zona = 0;
            $pedido->id_municipio = $dataPunto->id_municipio;
            $pedido->contenido = $this->contenido;
            $pedido->save();


            $pedidoPunto = new PedidoPunto;
            $pedidoPunto->id_pedido = $pedido->id;
            $pedidoPunto->id_punto = $this->punto;
            $pedidoPunto->save();

            PedidoPunto::where('id',$pedidoPunto->id)->update([
                'id_punto_pedido' => $pedidoPunto->id
            ]);


            $pedidoComercio = new PedidoComercio;
            $pedidoComercio->id_pedido = $pedido->id;
            $pedidoComercio->id_comercio = $this->comercio;
            $pedidoComercio->save();

            $log = new LogChangePedido;
            $log->id_pedido = $pedido->id;
            $log->id_repartidor = $this->repartidor;
            $log->id_zona = $this->zoneSelected;
            $log->accion = 'Pedido creado y asignado.';
            $log->save();


            $logPunto = new LogChangePedido;
            $logPunto->id_pedido = $pedido->id;
            $logPunto->id_repartidor = $this->repartidor;
            $logPunto->id_zona = $this->zoneSelected;
            $logPunto->accion = 'Pedido asignado asignado a punto de reparto.';
            $logPunto->save();

            DB::commit();
            $repartidorEmail = Repartidor::join('users','users.id','=','repartidores.id_usuario')->where('repartidores.id',$this->repartidor)->select('users.email','users.id')->first();
            $userNotification = User::where('id',$repartidorEmail->id)->select('users.*')->get();
            $expo = ExpoNotification::where('id_user',$repartidorEmail->id)->get();
            $numero = $pedido->id;
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


            //$this->dispatchBrowserEvent('closeModal'); 
            $this->alert('success', 'Pedido guardado con exito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Continuar',
                'allowOutsideClick'=>false,
                'allowEscapeKey' => false,
                'allowEnterKey' => false,
               ]);
           /* $this->alert('success', 'Pedido guardado correctamente', [
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Entendido',
                'onConfirmed' => 'confirmed'
            ]);*/

        } catch (\Throwable $th) {
            DB::rollBack();
             //$this->dispatchBrowserEvent('closeModal'); 
             $this->alert('error', 'Ocurrio un error, intenta nuevamente ', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
               ]);
        }
    }
   

    public function updatedZoneSelected()
    {
        
        if ($this->zoneSelected <> null) {
            $this->deliveries = Repartidor::join('users','users.id','=','repartidores.id_usuario')->join('detalles_zonas','detalles_zonas.id_repartidor','=','repartidores.id')
            ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')
            ->where('repartidores.estado',1)->where('detalles_zonas.id_zona',$this->zoneSelected)->whereNotNull('users.email_verified_at')
            ->select('users.name as nombre','repartidores.telefono','repartidores.id as id_repartidor','datos_vehiculos.tipo as tipo_vehiculo','datos_vehiculos.marca','datos_vehiculos.modelo',
            'datos_vehiculos.peso','datos_vehiculos.size')->get();                
        }
    }



    public function pagoQuestion($pedido)
    {
        $this->pedido = $pedido;
        $this->alert('question', '¿Marcar como pedido pagado?', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'pedidoPagado',
            'showCancelButton' => true,
            'onDismissed' => '',
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Si, pedido pagado',
        ]);
        
    }

    public function pedidoPagado()
    {
        try {
            Pedido::where('id', '=', $this->pedido)->update([
                'pago' => 1
            ]);
            $this->alert('success', 'Pedido marcado como pagado', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Continuar',
            ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrió un error, intenta nuevamente.', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
            ]);
        }
    }



    public function render()
    {
        if ($this->zoneSelected <> null) {
            $this->deliveries = Repartidor::join('users','users.id','=','repartidores.id_usuario')->join('detalles_zonas','detalles_zonas.id_repartidor','=','repartidores.id')
            ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')
            ->where('repartidores.estado',1)->where('detalles_zonas.id_zona',$this->zoneSelected)->whereNotNull('users.email_verified_at')
            ->select('users.name as nombre','repartidores.telefono','repartidores.id as id_repartidor','datos_vehiculos.tipo as tipo_vehiculo','datos_vehiculos.marca','datos_vehiculos.modelo',
            'datos_vehiculos.peso','datos_vehiculos.size')->get();     
        }                     
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }
        
        if ($this->municipio) {
           $this->puntos = PuntoReparto::where('id_municipio',$this->municipio)->get();
        }




        if ($this->departamento_envio) {
            $this->municipios_envios = Municipio::where('id_departamento',$this->departamento_envio)->get();
        }
        if ($this->municipio_envio) {
            $this->zones = Zona::where([
                ['estado',1],
                ['id_municipio',$this->municipio_envio]
            ])->select('nombre','id as id_zone')->get();  
        } 


        if ($this->opt == 2) {
            if ($this->comercio) {
                $this->direcciones = Direccion::where([
                    ['id_comercio',$this->comercio],
                    ['estado',1]
                ])->get();                           
            }
        } 
        if ($this->opt == 1){

            $this->direcciones = Direccion::where([
                ['id_usuario',Auth::id()],
                ['estado',1]
            ])->whereNull('id_comercio')->get();
        }

       
                                                        

        $this->comercios = Comercio::where('id_usuario',Auth::user()->id)->get();
        $this->direcciones_clientes = User::join('direcciones_clientes','direcciones_clientes.id_usuario','=','users.id')
        ->join('municipios','municipios.id','=','direcciones_clientes.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where([
           
            ['direcciones_clientes.estado',1]
        ])
        ->select('direcciones_clientes.*','municipios.nombre as municipio',
        'departamentos.nombre as departamento','departamentos.id as id_departamento')->get();

        return view('livewire.admin.pedido-component');
    }
}
