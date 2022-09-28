<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\{Pedido,Direccion,Departamento,Municipio,Repartidor,User,PedidoComercio,Comercio};
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

class UpdatePedido extends Component
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
    public $envio,$tipo_zona,$id_pedido,$repartidor,$contenido;
    public $direcciones_clientes = [],$comercios = [],$id_pedido_comercio,$comercio,$direccion_cliente;
    public $cod_search_comercio,$cod_search,$opt,$direcciones = [],$loader = false;

    protected $listeners = [
        'assingpedido',
        'confirmed'
    ];

    protected $rules = [
         'direccion_recogida'=> 'required',
        /*'direccion_entrega'=> 'required|min:20',
        'tel_cliente'=> 'required|min:8|max:20|regex:/^[0-9]{8}$/',     */

        'peso.required'=>'El peso del paquete es obligatorio',
        'peso' => 'required|numeric|min:0',
        'alto' => 'required|numeric|min:0',
        'ancho' => 'required|numeric|min:0',
        'profundidad' => 'required|numeric|min:0',

        'embalaje' => 'required',
        'fragil' => 'required',
        'contenido' => 'required',
        /* 'envio' => 'required', */

        /* 'cliente' => 'required',
        'dui' => 'required|min:9|max:10', */
        //'referencia' => 'nullable|min:10|max:255',
        //'tipo_zona' =>'required',

    ];

    protected $messages = [
        'direccion_recogida.required'=>'Dirección de recogida es obligatoria',
        /*'direccion_recogida.min'=>'Dirección de recogida debe contener un minimo de :min caracteres', */

       /*  'direccion_entrega.required'=>'Dirección de entrega es obligatoria',
        'direccion_entrega.min'=>'Dirección de entrega debe contener un minimo de :min caracteres', */

       /*  'tel_cliente.required' => 'El teléfono del cliente es obligatorio',
        'tel_cliente.min' => 'Debe contener un mínimo de :min caracteres',
        'tel_cliente.max' => 'Debe contener un máximo de :max caracteres',
        'tel_cliente.regex' => 'Formato no valido', */

        
        'contenido.required'=>'La descripción del contenido es obligatoria',
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
        
        'referencia.min' => 'La referencia de dirección debe contener un mínimo de :min caracteres',
        'referencia.max' => 'La referencia de dirección debe contener un máximo de :max caracteres',

       

    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }      

    public function confirmed()
    {
       return redirect('/administracion/creacion-pedidos');
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
        $this->contenido = $pedido['contenido'];
        $this->peso = $pedido['peso'];
        $this->alto = $pedido['alto'];
        $this->ancho = $pedido['ancho'];
        $this->profundidad = $pedido['profundidad'];
        $this->fragil = $pedido['fragil'];
        $this->embalaje = $pedido['tipo_embalaje'];
        $this->envio = $pedido['envio'];        
        $this->id_pedido = $pedido['pedido_id'];
        $this->repartidor = $pedido['id_repartidor'];

        $this->direccion_cliente = $pedido['id_dato_cliente'];

        $datosComercio = PedidoComercio::where('id_pedido', $pedido['pedido_id'])->select('id_comercio as comercio','id','id_pedido')->first();

        $this->comercio = $datosComercio->comercio;
        $this->id_pedido_comercio = $datosComercio->id_pedido;

        $checkTypeDireccion = Direccion::where([
            ['id_comercio',$this->comercio],
            ['direccion',$this->direccion_recogida]
        ])->value('id');
        if ($checkTypeDireccion) {
            $this->opt = 2;
        }else{
            $this->opt = 1;
        }


    }

    public function updatePedido()
    {
        $this->validate();
        try {
            $this->loader = true;
            DB::beginTransaction();
            Pedido::where('id',$this->id_pedido)->update([
                'direccion_recogida'=> $this->direccion_recogida,
                'id_dato_cliente' =>   $this->direccion_cliente,                                                                                             
                'peso' => $this->peso,
                'alto' => $this->alto,
                'ancho' => $this->ancho,
                'profundidad' => $this->profundidad,
                'fragil' => $this->fragil,
                'tipo_embalaje' => $this->embalaje,                
                'zona' => $this->tipo_zona,
                'contenido' => $this->contenido,
            ]);

            PedidoComercio::where('id',$this->id_pedido_comercio)->update([
               'id_comercio' => $this->comercio,
            ]);

            
            $repartidorEmail = Repartidor::join('users','users.id','=','repartidores.id_usuario')->where('repartidores.id',$this->repartidor)->select('users.email','users.id')->first();
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
            }
            DB::commit();
            $this->loader = false;
            $this->alert('success', 'Pedido actualizado con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
                'confirmButtonText' => 'Continuar',
               ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->alert('error', 'Ocurrió un error, intenta nuevamente', [
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

    public function searchComercio()
    {
        $this->comercio = Comercio::where('cod',$this->cod_search_comercio)->value('id');
    }







    public function render()
    {
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
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
        
        //$this->direcciones = Direccion::where('id_usuario',Auth::id())->get();
        $this->direcciones_clientes = User::join('direcciones_clientes','direcciones_clientes.id_usuario','=','users.id')
        ->join('municipios','municipios.id','=','direcciones_clientes.id_municipio')
        ->join('departamentos','departamentos.id','=','municipios.id_departamento')
        ->where([
            
            ['direcciones_clientes.estado',1]
        ])
        ->select('direcciones_clientes.*','municipios.nombre as municipio',
        'departamentos.nombre as departamento','departamentos.id as id_departamento')->get();

        $this->comercios = Comercio::get();
        return view('livewire.admin.update-pedido');
    }





    




}
