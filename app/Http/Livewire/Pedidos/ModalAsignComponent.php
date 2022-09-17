<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;
use App\Models\Zona;
use App\Models\{Repartidor,Departamento,Municipio};
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Mail\StatusPedido;
use Illuminate\Support\Facades\Mail;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;
use App\Models\ExpoNotification;
use Illuminate\Support\Facades\URL;
class ModalAsignComponent extends Component
{
    use LivewireAlert;
    public $id_pedido;
    public $zones = [];    
    public $zoneSelected;
    public $deliveries = [];
    public $repartidor;
    public $municipios = [],$departamentos = [];
    public $departamento,$municipio;
    public $listeners = ['resetInputAsign'=>'resetInput','redirectPedidos','asingIdPedido'=>'asign'];
    

    protected $rules = [
        'repartidor' => 'required',
        'zoneSelected' => 'required',
    ];

    protected $messages = [
        'repartidor.required'=>'Debes selecionar un repartidor',
        'zoneSelected.required'=>'Debes selecionar una zona de entrega',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['repartidor','zoneSelected']);
    }
    public function redirectPedidos()
    {
        $url = url()->previous();
        return redirect($url);
    }
   
    public function asign($id)
    {
        $this->id_pedido = $id;
    }

    public function reasignPedido()
    {
        $this->validate();
        try {
            Pedido::where('id',$this->id_pedido)->update([
                'id_repartidor' => $this->repartidor,
                'estado' => 0
            ]);
            $repartdorEmail = Repartidor::join('users','users.id','=','repartidores.id_usuario')->where('repartidores.id',$this->repartidor)->select('users.email','users.id')->first();
            $expo = ExpoNotification::where('id_user',$repartdorEmail->id)->get();
            $numero = $this->id_pedido;
            $state = 'El pedido No '.$numero.' se te a asignado. Entra a tu aplicación para aceptar o denegar el pedido';
            $to = $repartdorEmail->email;
                        
            Pedido::emailToUsersPedido($to,$numero,$state);
            
            $messages = [           
                new ExpoMessage([
                    'title' => 'Actualización de pedido',
                    'body' => $state,
                ]),];
                foreach ($expo as $ex ) {
                    (new Expo)->send($messages)->to([$ex->expo_token])->push();
            }

            $this->dispatchBrowserEvent('closeModalReasign'); 
            $this->alert('success', 'Pedido reasignado correctamente', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => 'redirectPedidos',
                    'confirmButtonText' => 'Continuar',
            ]);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('closeModalReasign'); 
            $this->alert('error', 'Ocurrió un error, intenta nuevamente', [
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
            ->where('repartidores.estado',1)->where('detalles_zonas.id_zona',$this->zoneSelected)
            ->select('users.name as nombre','repartidores.telefono','repartidores.id as id_repartidor','datos_vehiculos.tipo as tipo_vehiculo','datos_vehiculos.marca','datos_vehiculos.modelo',
            'datos_vehiculos.peso','datos_vehiculos.size')->get();                
        }
    }

    public function render()
    {
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }
        if ($this->municipio) {
            $this->zones = Zona::where([
                ['estado',1],
                ['id_municipio',$this->municipio]
            ])->select('nombre','id as id_zone')->get();   
        }
        
        
        if ($this->zoneSelected <> null) {
            $this->deliveries = Repartidor::join('users','users.id','=','repartidores.id_usuario')->join('detalles_zonas','detalles_zonas.id_repartidor','=','repartidores.id')
            ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')
            ->where('repartidores.estado',1)->where('detalles_zonas.id_zona',$this->zoneSelected)
            ->select('users.name as nombre','repartidores.telefono','repartidores.id as id_repartidor','datos_vehiculos.tipo as tipo_vehiculo','datos_vehiculos.marca','datos_vehiculos.modelo',
            'datos_vehiculos.peso','datos_vehiculos.size')->get();     
        }    
        
        return view('livewire.pedidos.modal-asign-component');
    }
}
