<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class DetalleComercio extends Component
{

    public $encargado,$correo,$dui,$telefono_encargado,$telefono,$comercio,$direccion;


    protected $listeners = [
        'assignComercio'
    ];


    public function assignComercio($comercio)
    {
        $this->encargado = $comercio['encargado'];
        $this->correo = $comercio['correo'];
        $this->telefono = $comercio['telefono'];
        $this->dui = $comercio['dui'];
        $this->comercio = $comercio['nombre'];
        $this->direccion = $comercio['direccion'];
        $this->telefono_encargado = $comercio['telefono_encargado'];
    }

    public function render()
    {
        return view('livewire.admin.detalle-comercio');
    }
}
