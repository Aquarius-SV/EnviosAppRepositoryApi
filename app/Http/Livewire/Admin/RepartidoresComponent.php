<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Repartidor;
class RepartidoresComponent extends Component
{
    public $nombre,$correo,$telefono,$dui,$nit,$licencia,$modelo,$marca,$tipo,$placa,$color,$peso,$demencion,$zonas =[];

    protected $listeners = [
        'assingRepartidor'
    ];
    public function assingRepartidor($repartidor)
    {
        $this->nombre = $repartidor['name'];
        $this->correo = $repartidor['email'];
        $this->telefono = $repartidor['telefono'];
        $this->dui = $repartidor['dui'];
        $this->nit = $repartidor['nit'];
        $this->licencia = $repartidor['licencia'];
        $this->tipo = $repartidor['tipo'];
        $this->placa = $repartidor['placa'];
        $this->marca = $repartidor['marca'];
        $this->color = $repartidor['color'];
        $this->modelo = $repartidor['modelo'];
        $this->peso = $repartidor['peso'];
        $this->demencion = $repartidor['size'];

        $this->zonas = Repartidor::join('detalles_zonas','detalles_zonas.id_repartidor','=','repartidores.id')
        ->join('zonas','zonas.id','=','detalles_zonas.id_zona')->where('detalles_zonas.id_repartidor',$repartidor['repartidor'])
        ->select('zonas.nombre as zona')->get();


    }



    public function render()
    {
        return view('livewire.admin.repartidores-component');
    }
}
