<?php

namespace App\Http\Livewire\Pedidos;

use Livewire\Component;
use App\Models\User;
class DetalleModalComponent extends Component
{
    public $direccion_recogida,$direccion_entrega,$referencia,$departamento,$municipio,
    $tel_cliente,$cliente,$dui,$peso,$alto,$ancho,$profundidad,$fragil,$embalaje,$envio,
    $repartidor,$estado;

    protected $listeners = [
        'assignDetalle'
    ];

    public function assignDetalle($detalle,$repartidor)
    {
        $this->direccion_recogida = $detalle['direccion_recogida'];
        $this->direccion_entrega = $detalle['direccion_entrega'];

        $this->referencia = $detalle['referencia'];
        $this->departamento = $detalle['departamento'];
        $this->municipio = $detalle['municipio'];

        $this->tel_cliente = $detalle['tel_cliente'];
        $this->cliente = $detalle['nombre_cliente'];
        $this->dui = $detalle['dui'];


        $this->peso = $detalle['peso'];
        $this->alto = $detalle['alto'];
        $this->ancho = $detalle['ancho'];

        $this->profundidad = $detalle['profundidad'];
        $this->fragil = $detalle['fragil'];
        $this->embalaje = $detalle['tipo_embalaje'];

        $this->envio = $detalle['envio'];
        $this->estado = $detalle['estado'];
        $this->fragil = $detalle['fragil'];

        $this->repartidor = User::where('id',$repartidor)->value('name');
    }




    public function render()
    {
        return view('livewire.pedidos.detalle-modal-component');
    }
}
