<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;
use App\Models\Zona;
use App\Models\Repartidor;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Municipio;
use App\Models\Departamento;
use Illuminate\Support\Facades\Notification;
use App\Models\ExpoNotification;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Mail\StatusPedido;
use App\Notifications\StatePedido;
use Illuminate\Support\Facades\Mail;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;

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
    public $municipio,$departamento;
    public $listeners = ['reset'=>'resetInput','confirmed','asigPedido'=>'asingPedido'];


    protected $rules = [
        'direccion_recogida'=> 'required|min:20',
        'direccion_entrega'=> 'required|min:20',
        'tel_cliente'=> 'required|min:8|max:20|regex:/^[0-9]{8}$/',
        'repartidor' => 'required',
        'zoneSelected' => 'required',
        'peso' => 'required',

        'alto' => 'required',
        'ancho' => 'required',
        'profundidad' => 'required',
        'embalaje' => 'required',
        'fragil' => 'required',
        'envio' => 'required',

        'cliente' => 'required',
        'dui' => 'required',

        'municipio' => 'required',
        'departamento' => 'required',

        'referencia' => 'required|min:10|max:255',
    ];

    protected $messages = [
        'direccion_recogida.required'=>'Dirección de recogida es obligatoria',
        'direccion_recogida.min'=>'Dirección de recogida debe contener un minimo de :min caracteres',

        'direccion_entrega.required'=>'Dirección de entrega es obligatoria',
        'direccion_entrega.min'=>'Dirección de entrega debe contener un minimo de :min caracteres',

        'tel_cliente.required' => 'El teléfono del cliente es obligatorio',
        'tel_cliente.min' => 'Debe contener un mínimo de :min caracteres',
        'tel_cliente.max' => 'Debe contener un máximo de :max caracteres',
        'tel_cliente.regex' => 'Formato no valido',

        'repartidor.required'=>'Debes selecionar un repartidor',
        'zoneSelected.required'=>'Debes selecionar una zona de entrega',

        
        'peso.required'=>'El peso del paquete es obligatorio',

        'alto.required'=>'El alto del paquete es obligatorio',
        'ancho.required'=>'El ancho del paquete es obligatorio',
        'profundidad.required'=>'La profundidad del paquete es obligatorio',
        
        'embalaje.required'=>'Debes seleccioner el tipo de embalaje',
        'fragil.required'=>'Debes seleccionar si el paquete',
        'envio.required'=>'Debes seleccionar el tipo de envío',

        'cliente.required'=>'El nombre del cliente es obligatorio',
        'dui.required'=>'El DUI del cliente es obligatorio',

        'departamento.required'=>'Debes seleccionar el departamento',
        'municipio.required'=>'Debes seleccionar el municipio',

        'referencia.required'=>'La referencia de dirección es obligatoria',
        'referencia.min' => 'La referencia de dirección debe contener un mínimo de :min caracteres',
        'referencia.max' => 'La referencia de dirección debe contener un máximo de :max caracteres',
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
    public function store()
    {
        $this->validate();       
        try {
            
            $pedido = new Pedido;
            $pedido->direccion_entrega = $this->direccion_entrega;
            $pedido->direccion_recogida = $this->direccion_recogida;
            $pedido->id_usuario = Auth::user()->id;
            $pedido->id_repartidor = $this->repartidor;
            $pedido->tel_cliente = $this->tel_cliente;
            $pedido->peso = $this->peso;            
            $pedido->fragil = $this->fragil;
            $pedido->alto = $this->alto;
            $pedido->ancho = $this->ancho;
            $pedido->profundidad = $this->profundidad;
            $pedido->dui = $this->dui;
            $pedido->envio = $this->envio;
            $pedido->tipo_embalaje = $this->embalaje;
            $pedido->id_municipio = $this->municipio;
            $pedido->nombre_cliente = $this->cliente;
            $pedido->referencia = $this->referencia;
            $pedido->save();
            
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
                'title' => 'Actualización de pedido',
                'body' => $state,
            ]),];
            foreach ($expo as $ex ) {
                (new Expo)->send($messages)->to([$ex->expo_token])->push();
            }


            $this->dispatchBrowserEvent('closeModal'); 
            $this->alert('success', 'Pedido guardado correctamente', [
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
             $this->dispatchBrowserEvent('closeModal'); 
            $this->alert('warning',$th->getMessage(), [
            'position' => 'center'
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
        $this->zones = Zona::where('estado',1)->select('nombre','id as id_zone')->get();       
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }
        return view('livewire.pedidos.modal-pedido-component');
    }
}
