<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;
use App\Models\{Zona,Repartidor,Pedido,User,Municipio,Departamento,Direccion,Comercio,LogChangePedido,PedidoComercio,PedidoPunto};
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
class ModalPedidoComponent extends Component
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
    public $municipio,$departamento,$direcciones = [];
    public $municipio_envio,$departamento_envio,$municipios_envios = [],$direcciones_clientes = [];

    public $step,$direccion_cliente,$contenido;

    public $listeners = ['reset'=>'resetInput','confirmed','asigPedido'=>'asingPedido'];


    protected $rules = [
        'direccion_recogida'=> 'required',
        /* 'direccion_entrega'=> 'required|min:20', */
        /* 'tel_cliente'=> 'required|min:8|max:20|regex:/^[0-9]{8}$/', */
       /*  'repartidor' => 'required',
        'zoneSelected' => 'required', */

        'peso' => 'required|numeric|min:0',
        'alto' => 'required|numeric|min:0',
        'ancho' => 'required|numeric|min:0',
        'profundidad' => 'required|numeric|min:0',

        'embalaje' => 'required',
        'fragil' => 'required',

        /* 'envio' => 'required', */

        'contenido' => 'required',
        /*'dui' => 'required|min:9|max:10',
        'referencia' => 'nullable|min:10|max:255', */
        

        /* 'municipio_envio' => 'required',
        'departamento_envio' => 'required',   */      
    ];

    protected $messages = [
        'direccion_recogida.required'=>'Dirección de recogida es obligatoria',
        'direccion_recogida.min'=>'Dirección de recogida debe contener un minimo de :min caracteres',

        /* 'direccion_entrega.required'=>'Dirección de entrega es obligatoria',
        'direccion_entrega.min'=>'Dirección de entrega debe contener un minimo de :min caracteres', */

        /* 'tel_cliente.required' => 'El teléfono del cliente es obligatorio',
        'tel_cliente.min' => 'Debe contener un mínimo de :min caracteres',
        'tel_cliente.max' => 'Debe contener un máximo de :max caracteres',
        'tel_cliente.regex' => 'Formato no valido', */

       /*  'repartidor.required'=>'Debes selecionar un repartidor',
        'zoneSelected.required'=>'Debes selecionar una zona de entrega', */

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
       /*  'envio.required'=>'Debes seleccionar el tipo de envío', */

        'contenido.required'=>'La descripción del contenido es obligatoria',
        /* 'dui.required'=>'El DUI del cliente es obligatorio',
        'dui.max'=>'Debe contener un máximo de :max caracteres',
        'dui.min'=>'Debe contener un mínimo de :min caracteres',
        
        'referencia.min' => 'La referencia de dirección debe contener un mínimo de :min caracteres',
        'referencia.max' => 'La referencia de dirección debe contener un máximo de :max caracteres', */

        /* 'departamento.required'=>'Debes seleccionar el departamento',
        'municipio.required'=>'Debes seleccionar el municipio',     */                            
    ];

    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['repartidor','zoneSelected','direccion_recogida','direccion_entrega','tel_cliente',
        'peso','alto','ancho','profundidad','embalaje','fragil','envio','cliente','dui',
        'municipio','departamento','municipios']);
    }
    
    public function confirmed()
    {
       return redirect('/pedidos');
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



    public function store()
    {
        $this->validate();  
        try {
            DB::beginTransaction();
                                

            $pedido = new Pedido;
            $pedido->id_dato_cliente = $this->direccion_cliente; 

            $pedidoCOunt = Pedido::select('id')->count();
            $codComercio = Comercio::join('users','users.id','=','comercios.id_usuario')->where('comercios.id_usuario',Auth::user()->id)->value('cod');

            $data = User::join('direcciones_clientes','direcciones_clientes.id_usuario','=','users.id')
            ->join('municipios','municipios.id','=','direcciones_clientes.id_municipio')
            ->join('departamentos','departamentos.id','=','municipios.id_departamento')
            ->where('direcciones_clientes.id',$this->direccion_cliente)
            ->select('direcciones_clientes.direccion','direcciones_clientes.id_municipio','departamentos.id as id_departamento')->first();          

            $pedido->sku = $pedidoCOunt.$codComercio.$data->id_departamento.$data->id_municipio;
            $pedido->id_municipio = $data->id_municipio;
            $pedido->direccion_entrega = $data->direccion;
            $pedido->direccion_recogida = $this->direccion_recogida;
            $pedido->negocio = 1;
            $pedido->id_usuario = Auth::user()->id;
                     
            $pedido->peso = $this->peso;            
            $pedido->fragil = $this->fragil;
            $pedido->alto = $this->alto;
            $pedido->ancho = $this->ancho;
            $pedido->profundidad = $this->profundidad;            
            $pedido->envio = 'Normal';
            $pedido->tipo_embalaje = $this->embalaje;       
            $pedido->zona = 1;
            $pedido->contenido = $this->contenido;
            $pedido->save();

            $log = new LogChangePedido;
            $log->id_pedido = $pedido->id;
            $log->id_repartidor = $this->repartidor;
            $log->id_zona = $this->zoneSelected;
            $log->accion = 'Pedido creado y asignado.';
            $log->save();

            $comecio = Comercio::where('id_usuario',Auth::user()->id)->value('id');
            $pedidoComercio = new PedidoComercio;
            $pedidoComercio->id_pedido = $pedido->id;
            $pedidoComercio->id_comercio = $comecio;
            $pedidoComercio->save();



            DB::commit();
           /*  $repartidorEmail = Repartidor::join('users','users.id','=','repartidores.id_usuario')->where('repartidores.id',$this->repartidor)->select('users.email','users.id')->first();
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
            } */


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
           /*$this->alert('success', 'Pedido guardado correctamente', [
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Entendido',
                'onConfirmed' => 'confirmed'
            ]);*/

        } catch (\Throwable $th) {
            DB::rollBack();
             /* $this->dispatchBrowserEvent('closeModal'); */ 
            $this->alert('warning',$th->getMessage(), [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
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
        if ($this->departamento_envio) {
            $this->municipios_envios = Municipio::where('id_departamento',$this->departamento_envio)->get();
        }
        if ($this->municipio_envio) {
            $this->zones = Zona::where([
                ['estado',1],
                ['id_municipio',$this->municipio_envio]
            ])->select('nombre','id as id_zone')->get();  
        } 



       
        $this->direcciones = Direccion::where('id_usuario',Auth::id())->get();
        $this->direcciones_clientes = User::join('direcciones_clientes','direcciones_clientes.id_usuario','=','users.id')
        ->join('municipios','municipios.id','=','direcciones_clientes.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('direcciones_clientes.id_usuario',Auth::user()->id)
        ->select('direcciones_clientes.*','municipios.nombre as municipio',
        'departamentos.nombre as departamento','departamentos.id as id_departamento')->get();
        return view('livewire.pedidos.modal-pedido-component');
    }
}
