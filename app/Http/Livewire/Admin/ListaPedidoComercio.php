<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Pedido;
class ListaPedidoComercio extends Component
{
    public $pedidos = [],$comercio,$fecha_inicio,$fecha_fin;


    protected $rules = [
        'fecha_inicio' => 'required',
        'fecha_fin' => 'required'
    ];

    protected $messages = [
        'fecha_inicio.required' => 'Debes selecionar la fecha de inicio',
        'fecha_fin.required' => 'Debes selecionar la fecha de fin',
    ];

    public $listeners = [
        'assignComercioDate'
    ];

    public function assignComercioDate($comercio)
    {
      $this->comercio = $comercio;
    }

    public function showList()
    {
        $this->validate();
        $this->dispatchBrowserEvent('close_up');
        $this->pedidos = Pedido::join('pedidos_comercios','pedidos_comercios.id_pedido','=','pedidos.id')
        ->where('pedidos_comercios.id_comercio',$this->comercio)->whereBetween('pedidos.created_at',[$this->fecha_inicio,$this->fecha_fin])->select('pedidos.*')->get(); 
    }
   


    public function render()
    {              
        return view('livewire.admin.lista-pedido-comercio');
    }
}
