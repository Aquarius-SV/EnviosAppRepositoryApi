<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LogChangePedido;
class TrackerPedido extends Component
{

    public $sku,$trackers = [],$alert = false;

    protected $rules = [
        'sku' => 'required',
    ];

    protected $messages = [
        'sku.required' =>'El sku es obligatorio.'
    ];


    public function getTracker()
    {   
        $this->validate();
        $result = LogChangePedido::join('pedidos','pedidos.id','=','change_log_pedido.id_pedido')
       ->where('pedidos.sku',$this->sku)->select('change_log_pedido.*')->get();

       if (count($result) > 0) {
        $this->trackers = $result;
       } else {
        $this->alert = true;
        $this->trackers = [];
       }
       
    }




    public function render()
    {
        return view('livewire.tracker-pedido');
    }
}
