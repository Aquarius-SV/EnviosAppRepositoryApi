<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\LogChangePedido;



class DetalleHistorial extends Component
{

    public $pedido,$detalle = [];

    protected $listeners = [
        'historialPedido'
    ];

    function historialPedido($pedido)
    {
        $this->pedido = $pedido;

        $this->detalle = LogChangePedido::where('id_pedido',$this->pedido)->get();


        
    }




    public function render()
    {
        return view('livewire.admin.detalle-historial');
    }
}
