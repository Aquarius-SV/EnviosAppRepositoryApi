<?php

namespace App\Http\Livewire\Repartidores;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Pedido;

class PedidosComponent extends Component
{
    public $id_pedido;
    use LivewireAlert;
 
    protected $listeners = [
        'acceptPedido',
        'rejectPedido',
        'acceptQuestion',
        'rejectQuestion',
        'redirectToPedidos'
    ];

    public function redirectToPedidos()
    {
        return redirect('/mis-pedidos');
    }



    public function acceptQuestion($id)
    {
        $this->id_pedido = $id;
        $this->alert('question', '¿Aceptar este pedido?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Si',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'position' => 'center',
            'timer' => 15000,
            'onConfirmed' => 'acceptPedido'
        ]);
    }

    public function rejectQuestion($id)
    {
        $this->id_pedido = $id;
        $this->alert('question', '¿Rechazar este pedido?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Si',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'position' => 'center',
            'timer' => 15000,
            'onConfirmed' => 'rejectPedido'
        ]);
    }


    public function acceptPedido()
    {

        try {
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 1
            ]);
            $this->alert('success', 'Pedido aceptado correctamente!',[
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Continuar',
                'onConfirmed' => 'redirectToPedidos',
                'timer'=>null,
                'allowOutsideClick' => false,
                'allowEscapeKey' => false,
                'allowEnterKey' => false,
            ]);

        } catch (\Throwable $th) {
            $this->alert('warning', 'Error al aceptar el pedido, intenta nuevamente',[
                'position' => 'center',
                'timer'=>15000
            ]);
        }
    }
    public function rejectPedido()
    {
        try {
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 7
            ]);
            $this->alert('success', 'Pedido rechazado correctamente!',[
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Continuar',
                'onConfirmed' => 'redirectToPedidos',
                'timer'=>null,
                'allowOutsideClick' => false,
                'allowEscapeKey' => false,
                'allowEnterKey' => false,
            ]);

        } catch (\Throwable $th) {
            $this->alert('warning', 'Error al rechazar el pedido, intenta nuevamente',[
                'position' => 'center',
                'timer'=>15000
            ]);
        }
       
    }



    public function render()
    {
        return view('livewire.repartidores.pedidos-component');
    }
}
