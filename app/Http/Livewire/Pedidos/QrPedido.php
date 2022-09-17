<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;

class QrPedido extends Component
{

    public $pedido;

    protected $listerners = [
        'assignPedidoID'
    ];

    public function assignPedidoID($pedido)
    {
        $this->pedido = $pedido;
    }

    public function render()
    {
        return view('livewire.pedidos.qr-pedido');
    }
}
