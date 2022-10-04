<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\{Direccion,Pedido,Departamento,Municipio};
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class DireccionRecogida extends Component
{
    use LivewireAlert;
    public $nombre,$direccion,$id_direccion,$estado,$old_estado,$departamentos = [],$municipios = [],$departamento,$municipio;

    protected $rules = [
        'nombre' => 'required',
        'direccion' => 'required',
        'departamento' => 'required',
        'municipio' => 'required',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio',
        'direccion.required' => 'La dirección es obligatoria',
        'departamento.required' => 'El departamento es obligatorio',
        'mmunicipio.required' => 'El municipio es obligatorio',
    ];
    
    protected $listeners = [
        'redirectDireccionRecogida',
        'assigDireccionRecogida',
        'deleteDireccionRecogida',
        'disableDireccion',

        'deleteQuestionDireccionRecogida',
        'disableQuestionDireccion',
        'resetDataDireccionRecogida'
    ];


    public function updated($propertyName)
    {
        
        $this->validateOnly($propertyName);
    }


    public function redirectDireccionRecogida()
    {
        $previous = url()->previous();
        return redirect($previous);
    }

    public function resetDataDireccionRecogida()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['nombre','direccion','id_direccion','estado','old_estado']);
    }

    public function assigDireccionRecogida($direccion)
    {
       $this->id_direccion = $direccion['id'];
       $this->direccion = $direccion['direccion'];
       $this->nombre = $direccion['nombre'];
       $this->estado = $direccion['estado'];
       $this->old_estado = $direccion['estado'];
       $this->municipio = $direccion['id_municipio'];
       $this->departamento = Municipio::join('departamentos', 'departamentos.id','=','municipios.id_departamento')->where('municipios.id',$direccion['id_municipio'])
       ->value('departamentos.id');

    }


    public function createDireccion()
    {
        $this->validate();
        try {
            $direccion = new Direccion;
            $direccion->nombre = $this->nombre;
            $direccion->direccion = $this->direccion;
            $direccion->id_municipio = $this->municipio;
            $direccion->id_usuario = Auth::user()->id;
            $direccion->save();
            $this->alert('success', 'Dirección guardada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectDireccionRecogida',
                'confirmButtonText' => 'Continuar',
               ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrio un error, intenta nuevamente', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
            ]);
        }
    }

    public function updateDireccion()
    {
        $this->validate();
        try {
            $direccion = Direccion::where('id',$this->id_direccion)->first();
            $direccion->nombre = $this->nombre;
            $direccion->direccion = $this->direccion;    
            $direccion->estado = $this->estado;   
            $direccion->id_municipio = $this->municipio;     
            $direccion->save();
            $this->alert('success', 'Dirección actualizada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectDireccionRecogida',
                'confirmButtonText' => 'Continuar',
               ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrio un error, intenta nuevamente', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
            ]);
        }
    }

    public function deleteQuestionDireccionRecogida($direccion)
    {
       $this->id_direccion = $direccion;
       $this->alert('question', '¿Eliminar esta dirección? ', [
        'position' => 'center',
        'timer' => '',
        'toast' => false,
        'showConfirmButton' => true,
        'onConfirmed' => 'deleteDireccionRecogida',
        'confirmButtonText' => 'Si, Eliminar',
        'showCancelButton' => true,
        'onDismissed' => '',
        'cancelButtonText' => 'Cancelar',
       ]);
    }


    public function deleteDireccionRecogida()
    {   
        $direccion = Direccion::where('id',$this->id_direccion)->value('direccion');

        $check = Pedido::where('direccion_recogida',$direccion)->count();

        if ($check > 0) {
            $this->alert('error', 'No puedes eliminar esta dirección', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => 'Existen registros con esta dirección',
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
               ]);
        } else {
            try {
                Direccion::where('id',$this->id_direccion)->delete();
                $this->alert('success', 'Dirección eliminada con éxito', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => 'redirectDireccionRecogida',
                    'confirmButtonText' => 'Continuar',
                ]);
           } catch (\Throwable $th) {
                $this->alert('error', 'Ocurrio un error, intenta nuevamente', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => '',
                    'confirmButtonText' => 'Entendido',
                ]);
           }
        }              
    }

    public function disableQuestionDireccion($direccion)
    {        
       $this->id_direccion = $direccion;   
       $this->alert('question', 'Desactivar esta dirección? ', [
        'position' => 'center',
        'timer' => '',
        'toast' => false,
        'showConfirmButton' => true,
        'onConfirmed' => 'disableDireccion',
        'confirmButtonText' => 'Si, Eliminar',
        'showCancelButton' => true,
        'onDismissed' => '',
        'cancelButtonText' => 'Cancelar',
       ]);
    }


    public function disableDireccion()
    {
        try {
            Direccion::where('id',$this->id_direccion)->update(['estado' => 0]);
            $this->alert('success', 'Dirección disactivada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectDireccionRecogida',
                'confirmButtonText' => 'Continuar',
            ]);
       } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrio un error, intenta nuevamente', [
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
        return view('livewire.admin.direccion-recogida');
    }
}
