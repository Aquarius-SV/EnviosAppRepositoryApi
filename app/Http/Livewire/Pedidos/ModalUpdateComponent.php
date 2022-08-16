<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;

use App\Models\Pedido;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class ModalUpdateComponent extends Component
{

    use LivewireAlert;
    
    public $id_pedido;
    public $repartidor;
    public $tel_cliente;
    public $peso;
    public $size;
    public $fragil;
    public $direccion_recogida;
    public $direccion_entrega;
    public $listeners = ['resetUp'=>'resetInput','asingPedido'=>'asingPedido','confirmed'];


    protected $rules = [
        'direccion_recogida'=> 'required|min:20',
        'direccion_entrega'=> 'required|min:20',
        'tel_cliente'=> 'required|min:8|max:20|regex:/(01)[0-9]{9}/',        
        'peso' => 'required',
        'size' => 'required'

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
        


        'peso.required'=>'El peso del paquete es obligatorio',
        'size.required'=>'El tamaña del paquete es obligatorio'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

   

    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['repartidor','direccion_recogida','direccion_entrega','tel_cliente','peso','size','fragil']);
    }

    public function asingPedido($pedido)
    {
        $this->id_pedido = $pedido['id_pedido'];
        $this->direccion_recogida = $pedido['direccion_recogida'];
        $this->direccion_entrega = $pedido['direccion_entrega'];
        $this->repartidor = $pedido['id_repartidor'];
        $this->tel_cliente = $pedido['tel_cliente'];
        $this->peso = $pedido['peso'];
        $this->size = $pedido['size'];   
        $this->fragil = $pedido['fragil'];         
    }

    public function confirmed()
    {
       return redirect('/pedidos');
    }

    public function PUpdate()
    {
        try {
            Pedido::where('id',$this->id_pedido)->update([
                'direccion_recogida' => $this->direccion_recogida,
                'direccion_entrega' => $this->direccion_entrega,
                'peso' => $this->peso,
                'size' => $this->size,
                'tel_cliente' => $this->tel_cliente,
                'fragil' => $this->fragil,
            ]);
            $this->dispatchBrowserEvent('closeModalUpd'); 
            $this->alert('success', 'Pedido actualizado correctamente', [
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Entendido',
                'onConfirmed' => 'confirmed'
            ]);

        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('closeModalUpd'); 
            $this->alert('warning','Ocurrio un problema, intenta nuevamente', [
            'position' => 'center'
            ]);
        }

      
    }



    public function render()
    {
       
        return view('livewire.pedidos.modal-update-component');
    }
}
