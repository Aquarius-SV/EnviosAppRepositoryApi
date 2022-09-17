<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\{User,Comercio,PedidoComercio};
class DetallePedido extends Component
{
    public $direccion_recogida,$direccion_entrega,$referencia,$departamento,$municipio,
    $tel_cliente,$cliente,$dui,$peso,$alto,$ancho,$profundidad,$fragil,$embalaje,$envio,
    $repartidor,$estado,$zona,$comercio,$contenido;

    protected $listeners = [
        'assignDetalle'
    ];

    public function assignDetalle($detalle,$repartidor,$repartidorPedidoPunto = null)
    {
        $this->direccion_recogida = $detalle['direccion_recogida'];
        $this->direccion_entrega = $detalle['direccion_entrega'];

        $this->referencia = $detalle['referencia'];
        $this->departamento = $detalle['departamento'];
        $this->municipio = $detalle['municipio'];

        $this->tel_cliente = $detalle['telefono'];
        $this->cliente = $detalle['nombre'];
        $this->dui = $detalle['dui'];


        $this->peso = $detalle['peso'];
        $this->alto = $detalle['alto'];
        $this->ancho = $detalle['ancho'];

        $this->profundidad = $detalle['profundidad'];
        $this->fragil = $detalle['fragil'];
        $this->embalaje = $detalle['tipo_embalaje'];

        $this->envio = $detalle['envio'];
        $this->estado = $detalle['pedido_estado'];
        $this->fragil = $detalle['fragil'];
        $this->zona = $detalle['zona'];
        $this->contenido = $detalle['contenido'];

        $this->comercio = PedidoComercio::join('comercios','comercios.id','=','pedidos_comercios.id_comercio')
        ->join('pedidos','pedidos.id','=','pedidos_comercios.id_pedido')->where('pedidos_comercios.id_pedido',$detalle['pedido_id'])->value('comercios.nombre');

        if ($repartidorPedidoPunto == null) {
            $this->repartidor = User::join('repartidores','repartidores.id_usuario','=','users.id')->where('repartidores.id',$repartidor)->value('name');
        }else {
            $this->repartidor = User::join('repartidores','repartidores.id_usuario','=','users.id')->where('repartidores.id',$repartidorPedidoPunto)->value('name');
        }
        
    }
    public function render()
    {
        return view('livewire.admin.detalle-pedido');
    }
}
