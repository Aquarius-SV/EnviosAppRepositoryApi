<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\{DireccionClienteModel,Pedido,Municipio,Departamento};
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DireccionCliente extends Component
{
    use LivewireAlert;
    public $nombre,$dui,$telefono,$referencia,$direccion,$whatsapp,$correo,$id_direccion,$estado,$old_estado;
    public $departamentos = [],$municipios = [],$municipio,$departamento,$comercio,$comercio_nombre,$direcciones = [];
    protected $rules = [
        'nombre' => 'required',
        'direccion' => 'required',
        'dui' => 'required|min:9|max:10',
        'telefono' => 'required|min:8|max:9',
        
        'whatsapp' => 'required|min:8|max:9',
        'correo' => 'required|email',

        'departamento' => 'required',
        'municipio' => 'required',

    ];

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio',
        'direccion.required' => 'La dirección es obligatoria',

        'dui.required' => 'El DUI es obligatorio',
        'dui.min' => 'Debe contener un mínimo de :min caracteres',
        'dui.max' => 'Debe contener un máximo de :min caracteres',


        'telefono.required' => 'El teléfono es obligatorio',
        'telefono.min' => 'Debe contener un mínimo de :min caracteres',
        'telefono.max' => 'Debe contener un máximo de :min caracteres',

        'whatsapp.required' => 'El teléfono con whatsapp es obligatorio',
        'whatsapp.min' => 'Debe contener un mínimo de :min caracteres',
        'whatsapp.max' => 'Debe contener un máximo de :min caracteres',

        'correo.required' => 'El correo es obligatorio',
        'correo.email' => 'Formato no valido',

        'municipio.required' => 'El municipio es obligatorio',
        'departamento.required' => 'El departamento es obligatorio',
    ];

    protected $listeners = [
        'redirectDireccionRecogida',
        'assigDireccionRecogida',
        'deleteDireccionRecogida',
        'disableDireccion',

        'deleteQuestionDireccionRecogida',
        'disableQuestionDireccion',
        'assignComercioOwner'
    ];


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function samePhone()
    {
        $this->whatsapp = $this->telefono;
    }

    public function redirectDireccionRecogida()
    {
        return redirect('/administracion/direcciones-clientes-finales');
    }

    public function assigDireccionRecogida($direccion)
    {
       $this->id_direccion = $direccion['id'];
       $this->direccion = $direccion['direccion'];
       $this->referencia = $direccion['referencia'];
       $this->nombre = $direccion['nombre'];
       $this->estado = $direccion['estado'];
       $this->old_estado = $direccion['estado'];
       $this->dui = $direccion['dui'];
       $this->telefono = $direccion['telefono'];
       $this->whatsapp = $direccion['numero_whatsapp'];
       $this->correo = $direccion['correo'];
       $this->municipio = $direccion['id_municipio'];
       $this->departamento = Municipio::where('id',$this->municipio)->value('id_departamento');
    }

    public function assignComercioOwner($comercio)
    {

       $this->comercio = $comercio['id'];
       $this->comercio_nombre = $comercio['nombre'];

    }

    public function createDireccion()
    {
        $this->validate();
        try {
            $direccionCount = DireccionClienteModel::count();
            $direccion = new DireccionClienteModel;
            $direccion->cod = $direccionCount.$this->departamento.$this->municipio;
            $direccion->nombre = $this->nombre;
            $direccion->direccion = $this->direccion;
            $direccion->dui = $this->dui;
            $direccion->telefono  = $this->telefono;
            $direccion->numero_whatsapp = $this->whatsapp;
            $direccion->correo = $this->correo;
            $direccion->id_municipio = $this->municipio;
            $direccion->referencia = $this->referencia;
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
            $direccion = DireccionClienteModel::where('id',$this->id_direccion)->first();                        
            $direccion->nombre = $this->nombre;
            $direccion->direccion = $this->direccion;
            $direccion->dui = $this->dui;
            $direccion->telefono  = $this->telefono;
            $direccion->numero_whatsapp = $this->whatsapp;
            $direccion->correo = $this->correo;
            $direccion->id_municipio = $this->municipio;
            $direccion->referencia = $this->referencia;            
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
        $direccion = DireccionClienteModel::where('id',$this->id_direccion)->value('direccion');

        $check = Pedido::where('direccion_entrega',$direccion)->count();

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
                DireccionClienteModel::where('id',$this->id_direccion)->delete();
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
            DireccionClienteModel::where('id',$this->id_direccion)->update(['estado' => 0]);
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

        if ($this->comercio) {
            $this->direcciones = DireccionClienteModel::where('id_comercio',$this->comercio)->get();
        }

        return view('livewire.admin.direccion-cliente');
    }
}
