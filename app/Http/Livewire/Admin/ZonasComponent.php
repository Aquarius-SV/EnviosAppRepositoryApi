<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\{Zona,Municipio,Departamento,DetallePuntoReparto};
use Jantinnerezo\LivewireAlert\LivewireAlert;
class ZonasComponent extends Component
{
    use LivewireAlert;

    public $zona,$estado,$old_estado,$nombre,$municipio,$departamento,$municipios = [],$departamentos = [];

    protected $rules = [
        'nombre' => 'required',
        'municipio' => 'required',
        'departamento' => 'required',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio',
        'municipio.required' => 'El municipio es obligatorio',
        'departamento.required' => 'El departamento es obligatorio',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public $listeners = [
        'redirectZona',
        'assignZonaReparto',
        'resetData',
        'questionDeleteOrDisable',
        'disableZonaReparto',
        'deleteZonaReparto'
    ];


    public function redirectZona()
    {
        return redirect('administracion/zonas-reparto');
    }

    public function resetData()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['zona','estado','old_estado','nombre','municipio','departamento']);
    }

    public function assignZonaReparto($zona)
    {
        $this->zona = $zona['id'];
        $this->nombre = $zona['nombre'];
        $this->departamento = $zona['id_departamento'];
        $this->municipio = $zona['id_municipio'];
        $this->estado = $zona['estado'];
        $this->old_estado = $zona['estado'];
    }

    public function saveZonaReparto()
    {
        $this->validate();
        try {
            $zona = new Zona;
            $zona->nombre = $this->nombre;
            $zona->id_municipio = $this->municipio;
            $zona->save();

            $this->alert('success', 'Zona de reparto guardada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectZona',
                'confirmButtonText' => 'Continuar',
            ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrió un error, intenta nuevamente', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
            ]);
        }
    }



    public function updateZonaReparto()
    {
        $this->validate();
        try {
            $zona = Zona::where('id', '=', $this->zona)->first();
            $zona->nombre = $this->nombre;
            $zona->id_municipio = $this->municipio;
            $zona->save();

            $this->alert('success', 'Zona de reparto guardada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectZona',
                'confirmButtonText' => 'Continuar',
            ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrió un error, intenta nuevamente', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
            ]);
        }
    }


    public function questionDeleteOrDisable($zona,$type)
    {
        $this->zona = $zona;

        if ($type == 'delete') {
            $this->alert('question', '¿Eliminar esta zona de reparto?', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'deleteZonaReparto',
                'showCancelButton' => true,
                'onDismissed' => '',
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Si, eliminar',
               ]);
        }else {
            $this->alert('question', '¿Desactivar esta zona de reparto?', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'disableZonaReparto',
                'showCancelButton' => true,
                'onDismissed' => '',
                'cancelButtonText' => 'Cancelar',
                'confirmButtonText' => 'Si, desactivar',
               ]);
        }

    }

    public function disableZonaReparto()
    {
        try {
            $zona = Zona::where('id', '=', $this->zona)->updated([
                'estado' => 0
            ]);

            $this->alert('success', 'Zona de reparto desactivada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectZona',
                'confirmButtonText' => 'Continuar',
            ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrió un error, intenta nuevamente', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
            ]);
        }
    }

    public function deleteZonaReparto()
    {   
        


        try {
            $zona = Zona::where('id', '=', $this->zona)->delete();

            $this->alert('success', 'Zona de reparto eliminada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectZona',
                'confirmButtonText' => 'Continuar',
            ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrió un error, intenta nuevamente', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
            ]);
        }
    }



    public function render()
    {
        $this->departamentos = Departamento::get();

        if ($this->departamento) {
           $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }

        return view('livewire.admin.zonas-component');
    }
}
