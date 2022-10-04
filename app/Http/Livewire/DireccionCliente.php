<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{Pedido,Departamento,Municipio,DireccionClienteModel};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use DB;
class DireccionCliente extends Component
{
    use LivewireAlert;

    public $nombre,$telefono,$dui,$direccion,$cliente,$usuario,$referencia,$departamento,$municipio,$telefono_wa,$correo;
    public $departamentos = [],$municipios = [];

    protected $listeners = [
        'redirectDireccion',
        'assingDireccion',
        'questionDelete',
        'deleteDireccion'
    ];

    protected $rules = [
        'nombre' => 'required',
        'telefono' => 'required',
        'telefono_wa' => 'required',
        'dui' => 'required',
        'direccion' => 'required',
        'departamento' => 'required',
        'municipio' => 'required',
        'correo' => 'email|nullable',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio',

        'telefono.required' => 'El telefono es obligatorio',

        'telefono_wa.required' => 'El telefono es obligatorio',

        'dui.required' => 'El DUI es obligatorio',
        'direccion.required' => 'La dirección es obligatorio',
        'departamento.required' => 'El departamento es obligatorio',
        'municipio.required' => 'El municipio es obligatorio',

        'correo.email' => 'Formato no valido'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function redirectDireccion()
    {
       return redirect('/pedidos/direcciones-clientes');
    }

    public function assingDireccion($direccion)
    {
        $this->nombre = $direccion['nombre'];
        $this->telefono = $direccion['telefono'];
        $this->dui = $direccion['dui'];
        $this->direccion = $direccion['direccion'];
        $this->cliente = $direccion['id'];
        $this->usuario = $direccion['id_usuario'];
        $this->referencia = $direccion['referencia'];
        $this->telefono_wa = $direccion['numero_whatsapp'];
        $this->correo = $direccion['correo'];
        $this->departamento = $direccion['id_departamento'];
        $this->municipio = $direccion['id_municipio'];

    }

    public function sameTelefono()
    {
       $this->telefono_wa = $this->telefono;
    }


    public function createDireccion()
    {
        $this->validate();       
        try {
            $direccionCount = DireccionClienteModel::count();
            $direccion = new DireccionClienteModel;
            $direccion->cod = $direccionCount.$this->departamento.$this->municipio;
            $direccion->telefono = $this->telefono;
            $direccion->direccion = $this->direccion;
            $direccion->referencia = $this->referencia;
            $direccion->id_municipio = $this->municipio;
            $direccion->nombre = $this->nombre;
            $direccion->dui = $this->dui;

            $direccion->numero_whatsapp = $this->telefono_wa;
            $direccion->correo = $this->correo;
            
            $direccion->id_usuario = Auth::id();
            $direccion->save();

            $this->alert('success', 'Dirección guardada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectDireccion',
                'confirmButtonText' => 'Continuar',
               ]);
        } catch (\Throwable $th) {            
            $this->alert('error', $th->getMessage()/* 'Ocurrió un error intenta nuevamente' */, [
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

            $direccion = DireccionClienteModel::where('id',$this->cliente)->first();
            $direccion->telefono = $this->telefono;
            $direccion->direccion = $this->direccion;
            $direccion->referencia = $this->referencia;
            $direccion->id_municipio = $this->municipio;
            $direccion->nombre = $this->nombre;
            $direccion->dui = $this->dui;   
            $direccion->numero_whatsapp = $this->telefono_wa;
            $direccion->correo = $this->correo;
            $direccion->save();

            
            $this->alert('success', 'Dirección actualizada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectDireccion',
                'confirmButtonText' => 'Continuar',
               ]);
        } catch (\Throwable $th) {
            
            $this->alert('error', 'Ocurrió un error intenta nuevamente', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
               ]);
        }
    }

    public function questionDelete($cliente)
    {
        $this->cliente = $cliente['id'];
        $this->direccion = $cliente['direccion'];
        $this->alert('question', '¿Eliminar esta dirección? ', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'deleteDireccion',
            'showCancelButton' => true,
            'onDismissed' => '',
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Si, eliminar',
           ]);
    }

    public function deleteDireccion()
    {
        $check = Pedido::where('direccion_entrega',$this->direccion)->count();


        if ($check > 0) {
            return  $this->alert('error', 'No puedes eliminar esta dirección, por que hay datos en uso', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
               ]);
        }else {
            try {
                
                DireccionClienteModel::where('id',$this->cliente)->delete();                                
                $this->alert('success', 'Dirección eliminada con éxito', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => 'redirectDireccion',
                    'confirmButtonText' => 'Continuar',
                   ]);
                
            } catch (\Throwable $th) {
                
                $this->alert('error', 'Ocurrió un error intenta nuevamente', [
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




    public function render()
    {
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }
        return view('livewire.direccion-cliente');
    }
}
