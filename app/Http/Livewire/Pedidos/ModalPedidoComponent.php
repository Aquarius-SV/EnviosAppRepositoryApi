<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;
use App\Models\Zona;
use App\Models\Repartidor;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ModalPedidoComponent extends Component
{
    use LivewireAlert;
    public $zones = [];
    public $zoneSelected;
    public $deliveries = [];
    public $repartidor;
    public $direccion_recogida;
    public $direccion_entrega;
    public $listeners = ['reset'=>'resetInput','confirmed','asigPedido'=>'asingPedido'];


    protected $rules = [
        'direccion_recogida'=> 'required|min:20',
        'direccion_entrega'=> 'required|min:20',
        'repartidor' => 'required',
        'zoneSelected' => 'required'

    ];

    protected $messages = [
        'direccion_recogida.required'=>'Dirección de recogida es obligatoria',
        'direccion_recogida.min'=>'Dirección de recogida debe contener un minimo de :min caracteres',

        'direccion_entrega.required'=>'Dirección de entrega es obligatoria',
        'direccion_entrega.min'=>'Dirección de entrega debe contener un minimo de :min caracteres',


        'repartidor.required'=>'Debes selecionar un repartidor',
        'zoneSelected.required'=>'Debes selecionar una zona de entrega',
    ];

    


    public function asigPedido($pedido)
    {
        $this->direccion_recogida = $pedido['direccion_recogida'];
        $this->direccion_entrega = $pedido['direccion_entrega'];
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
    public function confirmed()
    {
       return redirect('/pedidos');
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedZoneSelected()
    {
        if ($this->zoneSelected <> null) {
            $this->deliveries = Repartidor::join('users','users.id','=','repartidores.id_usuario')->join('detalles_zonas','detalles_zonas.id_repartidor','=','repartidores.id')
            ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')
            ->where('repartidores.estado',1)->where('detalles_zonas.id_zona',$this->zoneSelected)
            ->select('users.name as nombre','repartidores.telefono','repartidores.id as id_repartidor','datos_vehiculos.tipo as tipo_vehiculo')->get();
        }
    }
    

    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['repartidor','zoneSelected','direccion_recogida','direccion_entrega']);
    }


    public function render()
    {   
        if ($this->zoneSelected <> null) {
            $this->deliveries = Repartidor::join('users','users.id','=','repartidores.id_usuario')->join('detalles_zonas','detalles_zonas.id_repartidor','=','repartidores.id')
            ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')
            ->where('repartidores.estado',1)->where('detalles_zonas.id_zona',$this->zoneSelected)
            ->select('users.name as nombre','repartidores.telefono','repartidores.id as id_repartidor','datos_vehiculos.tipo as tipo_vehiculo')->get();
        }     
        $this->zones = Zona::where('estado',1)->select('nombre','id as id_zone')->get();              
        return view('livewire.pedidos.modal-pedido-component');
    }
}
