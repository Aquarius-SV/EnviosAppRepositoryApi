<?php

namespace App\Http\Livewire\Intermediario;

use DB;
use Livewire\Component;
use App\Models\{CodigoRetorno,PedidoPunto,Pedido};
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AceptarPedido extends Component
{  
    use LivewireAlert;
    public $pedido,$codigo;
    
    protected $rules = [
        'codigo' => 'required'
    ];


    protected $messages = [
        'codigo.required' => 'El código es obligatorio'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $listeners = [
        'assignPedido'
    ];

    public function assignPedido($pedido)
    {
       $this->pedido = $pedido;
    }

   /*  public function createPedidoPunto()
    {
        $pedido = new PedidoPunto;
        $pedido->id_pedido = $this->pedido;        
        $pedido->id_punto = 6;
        $pedido->save();

        $codigo = new CodigoRetorno;
        $codigo->cod = random_int(100000, 999999);
        $codigo->id_pedido = $this->pedido;
        $codigo->save();
    } */


    public function CodeValidate()
    {
        $this->Validate();
        $checkCod = CodigoRetorno::where('id_pedido',$this->pedido)->value('cod');

        if ($this->codigo == $checkCod) {
           try {
            DB::beginTransaction();
            PedidoPunto::where('id_pedido',$this->pedido)->update([
                'estado' => 1
            ]);
            Pedido::where('id',$this->pedido)->update([
                'estado' => 10
            ]); 
            DB::commit();
            $this->alert('success', 'Completado', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Continuar',
               ]);
           } catch (\Throwable $th) {
            DB::rollBack();
            $this->alert('error', 'Ocurrió un error, intenta nuevamente', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
               ]);
           }
          
        }else{
            $this->alert('error', 'El código no coincide con nuestros registros', [
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
        
        return view('livewire.intermediario.aceptar-pedido');
    }
}
