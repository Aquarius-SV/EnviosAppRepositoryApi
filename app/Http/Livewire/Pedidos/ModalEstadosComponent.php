<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\User;
use App\Models\ExpoNotification;
use App\Mail\StatusPedido;
use Illuminate\Support\Facades\Mail;
use App\Notifications\StatePedido;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Notification;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;

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
      
        $this->id_pedido = $pedido['id'];
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
            'toast' => false,
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
            'toast' => false,
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
            ->join('users','users.id','=','repartidores.id_usuario')->where('pedidos.id',$this->id_pedido)->select('users.email','users.id')->first();
            $userNotification = User::where('id',$repartdorEmail->id)->select('users.*')->get();          
            $numero = $this->id_pedido;
            $state = 'El pedido No '.$this->id_pedido.' esta disponible siendo preparado';
            $to = $repartdorEmail->email;
            $expo = ExpoNotification::where('id_user',$repartdorEmail->id)->get();
            
            Pedido::emailToUsersPedido($to,$numero,$state);
            
            $data = [                
                'concepto' => $state
            ];
            
            Notification::send($userNotification , new StatePedido($data));            
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 2
            ]);
            
            //EXPO
           $messages = [           
            new ExpoMessage([
                'title' => 'Actualización de pedido',
                'body' => $state,
            ]),];
            foreach ($expo as $ex ) {
                (new Expo)->send($messages)->to([$ex->expo_token])->push();
            }
           
            $this->alert('success', 'Estado del pedido actualizando correctamente!',[
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Continuar',
                'onConfirmed' => 'redirectToPedidos',
                'timer'=>null,
                'allowOutsideClick' => false,
                'allowEscapeKey' => false,
                'allowEnterKey' => false,
                'toast' => false,
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
            ->join('users','users.id','=','repartidores.id_usuario')->where('pedidos.id',$this->id_pedido)->select('users.email','users.id')->first();
            $userNotification = User::where('id',$repartdorEmail->id)->select('users.*')->get();
            $expo = ExpoNotification::where('id_user',$repartdorEmail->id)->get();
            $numero = $this->id_pedido;
            $state = 'El pedido No '.$this->id_pedido.' esta disponible para recogida';
            $to = $repartdorEmail->email;
            
            
            Pedido::emailToUsersPedido($to,$numero,$state);
            
            $data = [                
                'concepto' => $state
            ];            
            Notification::send($userNotification, new StatePedido($data));        
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 3
            ]);    
           //EXPO
            $messages = [           
                new ExpoMessage([
                    'title' => 'Actualización de pedido',
                    'body' => $state,
                ]),];
            foreach ($expo as $ex ) {
                (new Expo)->send($messages)->to([$ex->expo_token])->push();
            }

            $this->alert('success', 'Estado del pedido actualizando correctamente!',[
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Continuar',
                'onConfirmed' => 'redirectToPedidos',
                'timer'=>null,
                'allowOutsideClick' => false,
                'allowEscapeKey' => false,
                'allowEnterKey' => false,
                'toast' => false,
            ]);

        } catch (\Throwable $th) {
            $this->alert('warning', 'Error al actualizar el estado del pedido, intenta nuevamente',[
                'position' => 'center',
                'timer'=>15000,
                'toast' => false,
            ]);
        }
    }




    public function render()
    {
        return view('livewire.pedidos.modal-estados-component');
    }
}
