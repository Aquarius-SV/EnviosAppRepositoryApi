<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use App\Models\{Departamento,Municipio,PuntoReparto};
class IntermediarioPunto extends Component
{
    public $punto,$url,$departamento,$municipio;
    public $departamentos = [],$municipios = [],$puntos = [];
    public $nombre,$dui,$correo,$telefono,$cargo,$estado,$direccion;



    protected  $listeners = [
        'assignInter'
    ];


    public function generateUrl()
    {
        
        $day = Carbon::now()->addDays(3);

        $this->url =  URL::temporarySignedRoute('intermediacion', $day, ['punto' => $this->punto]);

    }


    public function assignInter($inter)
    {
       $this->nombre = $inter['nombre'];
       $this->dui = $inter['dui'];
       $this->correo = $inter['correo'];
       $this->telefono = $inter['telefono'];
       $this->cargo = $inter['cargo'];
       $this->estado = $inter['estado'];  
       $this->direccion = $inter['direccion'];
    }




    public function render()
    {
        $this->departamentos = Departamento::get();

        if ($this->departamento) {
           $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }

        if ($this->municipio) {
           $this->puntos = PuntoReparto::where('id_municipio',$this->municipio)->get();
        }


        return view('livewire.admin.intermediario-punto');
    }
}
