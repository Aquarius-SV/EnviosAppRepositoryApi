<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;

use App\Models\{Pedido,Direccion,Departamento,Municipio,Repartidor,User};
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Notification;
use App\Models\ExpoNotification;
use App\Mail\StatusPedido;
use App\Notifications\StatePedido;
use Illuminate\Support\Facades\Mail;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use DB;

class ModalUpdateComponent extends Component
{

    use LivewireAlert;
    
    public $departamentos = [],
    $departamentos_envios=[],
    $municipios = [],
    $municipios_envios = [];
    public $departamento_envio;
    public $direccion_recogida,$direccion_entrega,$referencia,$departamento,$municipio,
    $cliente,$tel_cliente,$dui;
    public $peso,$alto,$ancho,$profundidad,$fragil,$embalaje;
    public $envio,$tipo_zona,$id_pedido,$repartidor,$direccion_cliente,$direcciones_clientes = [],$contenido;
    protected $listeners = [
        'assingpedido',
        'confirmed'
    ];

    protected $rules = [
        'direccion_recogida'=> 'required',
        'direccion_cliente'=> 'required',
        'contenido' => 'required',
        //'tel_cliente'=> 'required|min:8|max:20|regex:/^[0-9]{8}$/',    

        'peso.required'=>'El peso del paquete es obligatorio',
        'peso' => 'required|numeric|min:0',
        'alto' => 'required|numeric|min:0',
        'ancho' => 'required|numeric|min:0',
        'profundidad' => 'required|numeric|min:0',

        'embalaje' => 'required',
        'fragil' => 'required',
        /* 'envio' => 'required', */

        'cliente' => 'required',
        /* 'dui' => 'required|min:9|max:10',
        'referencia' => 'nullable|min:10|max:255', */
        

    ];

    protected $messages = [
        'direccion_recogida.required'=>'Dirección de recogida es obligatoria',
        'contenido.required'=>'El contenido es obligatorio',

        'direccion_cliente.required'=>'Dirección de entrega es obligatoria',
        
                
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
        /* 'envio.required'=>'Debes seleccionar el tipo de envío', */

        'cliente.required'=>'El nombre del cliente es obligatorio',
        /* 'dui.required'=>'El DUI del cliente es obligatorio',
        'dui.max'=>'Debe contener un máximo de :max caracteres',
        'dui.min'=>'Debe contener un mínimo de :min caracteres',
        
        'referencia.min' => 'La referencia de dirección debe contener un mínimo de :min caracteres',
        'referencia.max' => 'La referencia de dirección debe contener un máximo de :max caracteres', */

       

    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }      

    public function confirmed()
    {
       return redirect('/pedidos');
    }

    public function assingpedido($pedido)
    {
        $this->direccion_recogida = $pedido['direccion_recogida'];
        $this->direccion_entrega = $pedido['direccion_entrega'];
        $this->referencia = $pedido['referencia'];
        $this->departamento = $pedido['id_departamento'];
        $this->municipio = $pedido['id_municipio'];
        $this->cliente = $pedido['nombre'];
        $this->tel_cliente = $pedido['telefono'];
        $this->dui = $pedido['dui'];
        $this->direccion_cliente = $pedido['id_dato_cliente'];
        $this->peso = $pedido['peso'];
        $this->alto = $pedido['alto'];
        $this->ancho = $pedido['ancho'];
        $this->profundidad = $pedido['profundidad'];
        $this->fragil = $pedido['fragil'];
        $this->embalaje = $pedido['tipo_embalaje'];

        $this->envio = $pedido['envio'];        
        $this->contenido = $pedido['contenido'];
        $this->id_pedido = $pedido['id_pedido'];
        $this->repartidor = $pedido['id_repartidor'];
    }

    public function updatePedido()
    {
        $this->validate();
        try {
            Pedido::where('id',$this->id_pedido)->update([
                'direccion_recogida'=> $this->direccion_recogida,
                'id_dato_cliente' => $this->direccion_cliente,                             
                'peso' => $this->peso,
                'alto' => $this->alto,
                'ancho' => $this->ancho,
                'profundidad' => $this->profundidad,
                'fragil' => $this->fragil,
                'tipo_embalaje' => $this->embalaje,                
                'contenido' => $this->contenido,          
            ]);


           /*  $repartidorEmail = Repartidor::join('users','users.id','=','repartidores.id_usuario')->where('repartidores.id',$this->repartidor)->select('users.email','users.id')->first();
            $userNotification = User::where('id',$repartidorEmail->id)->select('users.*')->get();
            $expo = ExpoNotification::where('id_user',$repartidorEmail->id)->get();

            $state = 'Los datos del pedido No '.$this->id_pedido.' fuerón actualizados.';
            $to = $repartidorEmail->email;
                    
            Pedido::emailToUsersPedido($to,$this->id_pedido,$state);

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
            } */
            $this->alert('success', 'Pedido actualizado con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Continuar',
               ]);
        } catch (\Throwable $th) {
            $this->alert('error', $th->getMessage(), [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => 'Si el error persiste, intenta más tarde.',
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
               ]);
        }
    }



    public function render()
    {
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }
        if ($this->departamento_envio) {
            $this->municipios_envios = Municipio::where('id_departamento',$this->departamento_envio)->get();
        }
        $this->direcciones = Direccion::where('id_usuario',Auth::id())->get();
        $this->direcciones_clientes = User::join('direcciones_clientes','direcciones_clientes.id_usuario','=','users.id')
        ->join('municipios','municipios.id','=','direcciones_clientes.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where('direcciones_clientes.id_usuario',Auth::user()->id)
        ->select('direcciones_clientes.*','municipios.nombre as municipio',
        'departamentos.nombre as departamento','departamentos.id as id_departamento')->get();

        return view('livewire.pedidos.modal-update-component');
    }
}
