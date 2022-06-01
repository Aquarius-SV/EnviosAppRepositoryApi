<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;
use App\Models\Zona;
use App\Models\Repartidor;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ModalPedidoComponent extends Component
{
    use LivewireAlert;
    public $zones = [];
    
    public $zoneSelected;
    public $deliveries = [];
    public $repartidor;
    public $tel_cliente;
    public $peso;
    public $size;
    public $fragil;
    public $direccion_recogida;
    public $direccion_entrega;
    public $listeners = ['resetUp'=>'resetInput','confirmed','asigPedido'=>'asingPedido'];


    protected $rules = [
        'direccion_recogida'=> 'required|min:20',
        'direccion_entrega'=> 'required|min:20',
        'tel_cliente'=> 'required|min:8|max:20|regex:/^[0-9]{8}$/',
        'repartidor' => 'required',
        'zoneSelected' => 'required',
        'peso' => 'required',
        'size' => 'required',
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
        'size.required'=>'El tamaño del paquete es obligatorio'
    ];

    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['repartidor','zoneSelected','direccion_recogida','direccion_entrega','tel_cliente','peso','size','fragil']);
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
            $pedido->size = $this->size;
            $pedido->save();

            $this->dispatchBrowserEvent('closeModal'); 
            $this->alert('success', 'Pedido guardado correctamente', [
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Entendido',
                'onConfirmed' => 'confirmed'
            ]);

        } catch (\Throwable $th) {
             $this->dispatchBrowserEvent('closeModal'); 
            $this->alert('warning','Ocurrio un problema, intenta nuevamente', [
            'position' => 'center'
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
      
        if ($this->zoneSelected <> null) {
            $this->deliveries = Repartidor::join('users','users.id','=','repartidores.id_usuario')->join('detalles_zonas','detalles_zonas.id_repartidor','=','repartidores.id')
            ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')
            ->where('repartidores.estado',1)->where('detalles_zonas.id_zona',$this->zoneSelected)
            ->select('users.name as nombre','repartidores.telefono','repartidores.id as id_repartidor','datos_vehiculos.tipo as tipo_vehiculo','datos_vehiculos.marca','datos_vehiculos.modelo',
            'datos_vehiculos.peso','datos_vehiculos.size')->get();     
        }    
        $this->zones = Zona::where('estado',1)->select('nombre','id as id_zone')->get();              
        return view('livewire.pedidos.modal-pedido-component');
    }
}
