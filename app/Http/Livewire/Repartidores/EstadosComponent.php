<?php

namespace App\Http\Livewire\Repartidores;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Pedido;
use App\Notifications\StatePedido;
class EstadosComponent extends Component
{
    public $id_pedido,$estado;
    use LivewireAlert;

    protected $listeners = [
        'asingId',
        'redirectToPedidos',
        'recogerAccept',
        'transitoAccept',
        'entregadoAccept',
        'noEntregadoAccept'
        
    ];

    public function asingId($data)
    {
        $this->id_pedido = $data['id_pedido'];
        $this->estado = $data['estado'];
    }
    public function redirectToPedidos()
    {
        return redirect('/mis-pedidos');
    }

    public function recogerQuestion()
    {
       
        $this->alert('question', '¿Cambiar el estado del pedido a: pedido recogido?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Si',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'position' => 'center',
            'timer' => 15000,
            'onConfirmed' => 'recogerAccept'
        ]);
    }

    public function transitoQuestion()
    {
       
        $this->alert('question', '¿Cambiar el estado del pedido a: pedido en transito?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Si',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'position' => 'center',
            'timer' => 15000,
            'onConfirmed' => 'transitoAccept'
        ]);
    }

    public function entregadoQuestion()
    {
       
        $this->alert('question', '¿Cambiar el estado del pedido a: pedido entregado?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Si',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'position' => 'center',
            'timer' => 15000,
            'onConfirmed' => 'entregadoAccept'
        ]);
    }

    public function noEntregadoQuestion()
    {
       
        $this->alert('question', '¿Cambiar el estado del pedido a: pedido no entregado?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Si',
            'showCancelButton' => true,
            'cancelButtonText' => 'Cancelar',
            'position' => 'center',
            'timer' => null,
            'input' => 'text',
            'inputPlaceholder' => 'Motivo',
            'inputValidator' => '(value) => new Promise((resolve) => '.
            '  resolve('.
            '    /^(?!\s*$).+/.test(value) ?'.
            '    undefined : "El motivo es obligatorio"'.
            '  )'.
            ')',   
            'onConfirmed' => 'noEntregadoAccept',
            'allowOutsideClick' => false,
            'allowEscapeKey' => false,
            'allowEnterKey' => false,
        ]);
    }


    public function recogerAccept()
    {
        try {
            $userEmail = Pedido::join('users','users.id','=','pedidos.id_usuario')->where('pedidos.id',$this->id_pedido)->select('users.*')->get();
            $numero = $this->id_pedido;
            $state = 'El pedido No '.$this->id_pedido.' a sido recogido';
            $to = 'diegouriel.martinez15@gmail.com';
            
            /* falta poner esto en el to del email repartidor  $userEmail[0]->email*/
            Pedido::emailToUsersPedido($to,$numero,$state);
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 4
            ]);
            $data = [                
                'concepto' => $state
            ];            
            Notification::send($userEmail , new StatePedido($data));   
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

    public function transitoAccept()
    {
        try {
            $userEmail = Pedido::join('users','users.id','=','pedidos.id_usuario')->where('pedidos.id',$this->id_pedido)->select('users.*')->get();
            $numero = $this->id_pedido;
            $state = 'El pedido No '.$this->id_pedido.' esta en transito';
            $to = 'diegouriel.martinez15@gmail.com';
            
            /* falta poner esto en el to del email repartidor  $userEmail[0]->email*/
            Pedido::emailToUsersPedido($to,$numero,$state);
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 5
            ]);
            $data = [                
                'concepto' => $state
            ];   
            Notification::send($userEmail , new StatePedido($data));
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



    public function entregadoAccept()
    {
        try {
            $userEmail = Pedido::join('users','users.id','=','pedidos.id_usuario')->where('pedidos.id',$this->id_pedido)->select('users.*')->get();
            $numero = $this->id_pedido;
            $state = 'El pedido No '.$this->id_pedido.' se a entregado al cliente';
            $to = 'diegouriel.martinez15@gmail.com';
            
            /* falta poner esto en el to del email repartidor  $userEmail[0]->email*/
            Pedido::emailToUsersPedido($to,$numero,$state);
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 6
            ]);
            $data = [                
                'concepto' => $state
            ];   
            Notification::send($userEmail , new StatePedido($data));
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

    public function noEntregadoAccept($data)
    {
        try {

            $userEmail = Pedido::join('users','users.id','=','pedidos.id_usuario')->where('pedidos.id',$this->id_pedido)->select('users.*')->get();
            $numero = $this->id_pedido;
            $state = 'El pedido No'.$this->id_pedido.' no se entrego. Motivo: '.$data['value'];
            $to = 'diegouriel.martinez15@gmail.com';
            
            /* falta poner esto en el to del email repartidor  $userEmail[0]->email*/
            Pedido::emailToUsersPedido($to,$numero,$state);
            Pedido::where('id',$this->id_pedido)->update([
                'estado' => 8,
                'motivo' =>$data['value']
            ]);
            $data = [                
                'concepto' => $state
            ];   
            Notification::send($userEmail , new StatePedido($data));
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
        return view('livewire.repartidores.estados-component');
    }
}
