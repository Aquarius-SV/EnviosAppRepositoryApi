<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;

use App\Models\Pedido;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class ModalUpdateComponent extends Component
{

    use LivewireAlert;
    
    public $id_pedido;
    public $direccion_recogida;
    public $direccion_entrega;
    public $listeners = ['asingPedido'=>'asingPedido','confirmed'];


    protected $rules = [
        'direccion_recogida'=> 'required|min:20',
        'direccion_entrega'=> 'required|min:20',
        

    ];

    protected $messages = [
        'direccion_recogida.required'=>'Dirección de recogida es obligatoria',
        'direccion_recogida.min'=>'Dirección de recogida debe contener un minimo de :min caracteres',

        'direccion_entrega.required'=>'Dirección de entrega es obligatoria',
        'direccion_entrega.min'=>'Dirección de entrega debe contener un minimo de :min caracteres',


        
    
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

   

    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['direccion_recogida','direccion_entrega']);
    }

    public function asingPedido($pedido)
    {
        $this->direccion_recogida = $pedido['direccion_recogida'];
        $this->direccion_entrega = $pedido['direccion_entrega'];
        $this->id_pedido = $pedido['id_pedido'];
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
                'direccion_entrega' => $this->direccion_entrega
            ]);
            $this->dispatchBrowserEvent('closeModal'); 
            $this->alert('success', 'Pedido actualizado correctamente', [
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



    public function render()
    {
       
        return view('livewire.pedidos.modal-update-component');
    }
}
