<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;
use App\Mail\StatusPedido;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StatePedido;
class ModalEstadosComponent extends Component
{
    use LivewireAlert;
    public $id_pedido,$estado;  
    public $listeners = ['asingId'=>'asingId','redirectToPedidos','preparacionAccept','recogerAccept'];

    public function redirectToPedidos()
    {
        return redirect('/pedidos');
    }
    public function asingId($pedido)
    {
      
        $this->id_pedido = $pedido['id_pedido'];
        $this->estado = $pedido['estado'];
    }

    public function preparacionQuestion()
    {
        $this->alert('question', '¿Cambiar el estado del pedido a: pedido en preparación?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Si',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'position' => 'center',
            'timer' => 15000,
            'onConfirmed' => 'preparacionAccept'
        ]);
    }

    public function recogerQuestion()
    {
        $this->alert('question', '¿Cambiar el estado del pedido a: pedido listo para recoger?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Si',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'position' => 'center',
            'timer' => 15000,
            'onConfirmed' => 'recogerAccept'
        ]);
    }

    public function preparacionAccept()
    {

        
        try {
            $repartdorEmail = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')
            ->join('users','users.id','=','repartidores.id_usuario')->where('pedidos.id',$this->id_pedido)->select('users.email','users.id')->get();
            $userNotification = User::where('id',$repartdorEmail[0]->id)->select('users.*')->get();
           
            $numero = $this->id_pedido;
            $state = 'El pedido No '.$this->id_pedido.' esta disponible siendo preparado';
            $to = 'diegouriel.martinez15@gmail.com';
            
            /*falta poner esto en el to del email repartidor  $repartdorEmail[0]->email*/
            Pedido::emailToUsersPedido($to,$numero,$state);
            //Mail::to('diegouriel.martinez15@gmail.com')->send(new StatusPedido($numero,$state));
            $data = [                
                'concepto' => $state
            ];
            
            Notification::send($userNotification , new StatePedido($data));            
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 2
            ]);
            $this->alert('success', 'Estado del pedido actualizando correctamente!',[
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
            $this->alert('warning', 'Error al actualizar el estado del pedido, intenta nuevamente',[
                'position' => 'center',
                'timer'=>15000
            ]);
        }
    }

    public function recogerAccept()
    {
        try {
            $repartdorEmail = Pedido::join('repartidores','repartidores.id','=','pedidos.id_repartidor')
            ->join('users','users.id','=','repartidores.id_usuario')->where('pedidos.id',$this->id_pedido)->select('users.email','users.id')->get();
            $userNotification = User::where('id',$repartdorEmail[0]->id)->select('users.*')->get();
           
            $numero = $this->id_pedido;
            $state = 'El pedido No '.$this->id_pedido.' esta disponible para recogida';
            $to = 'diegouriel.martinez15@gmail.com';
            
            /* falta poner esto en el to del email repartidor  $repartdorEmail[0]->email*/
            Pedido::emailToUsersPedido($to,$numero,$state);
            //Mail::to('diegouriel.martinez15@gmail.com')->send(new StatusPedido($numero,$state));
            $data = [                
                'concepto' => $state
            ];            
            Notification::send($userNotification, new StatePedido($data));        
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 3
            ]);        
            $this->alert('success', 'Estado del pedido actualizando correctamente!',[
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
            $this->alert('warning', 'Error al actualizar el estado del pedido, intenta nuevamente',[
                'position' => 'center',
                'timer'=>15000
            ]);
        }
    }




    public function render()
    {
        return view('livewire.pedidos.modal-estados-component');
    }
}
