<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Pedido;

class PedidosList extends Component
{

    public $pedidos;

    public function render()
    {
        $this->pedidos = Pedido::join('users','users.id','=','pedidos.id_usuario')
       ->join('municipios','municipios.id','=','pedidos.id_municipio')->join('departamentos','departamentos.id','=','municipios.id_departamento')
       ->join('direcciones_clientes','direcciones_clientes.id','=','pedidos.id_dato_cliente')
       ->select('pedidos.*','users.name as comercio','municipios.nombre as municipio','departamentos.nombre as departamento'
       ,'departamentos.id as id_departamento','direcciones_clientes.*','pedidos.id as id_pedido')->get();

        return view('livewire.admin.pedidos-list');
    }
}
