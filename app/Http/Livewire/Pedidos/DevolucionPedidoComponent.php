<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;
use App\Models\{CodigoRetorno,Pedido};
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DevolucionPedidoComponent extends Component
{
    use LivewireAlert;
    public $pedido,$code;

    protected $listeners = [
        'assignPedido',
        'redirectPedido'
    ];
    
    public function assignPedido($pedido)
    {
        $this->pedido = $pedido;
    }

    public function redirectPedido()
    {
      
       return redirect('/pedidos/devoluciones');
    }

    public function validateCode()
    {
       $originalCode = CodigoRetorno::where('id_pedido',$this->pedido)->value('cod');
        try {
            if ($originalCode == $this->code) {
                Pedido::where('id',$this->pedido)->update([
                    'estado' => 10
                ]); 
                $this->alert('success', 'Devolución validada con éxito ', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => 'redirectPedido',
                    'confirmButtonText' => 'Continuar',
                ]);          
           }else{
                $this->alert('error', 'El código proporcionado no coincide con nuestros registros', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => '',
                    'confirmButtonText' => 'Entendido',
                ]);
           }
        } catch (\Throwable $th) {
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


    public function render()
    {
        return view('livewire.pedidos.devolucion-pedido-component');
    }
}
