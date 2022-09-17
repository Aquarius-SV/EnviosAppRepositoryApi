<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\{Comercio,PedidoComercio,Departamento,Municipio};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
class DatoCliente extends Component
{
    use LivewireAlert;
    public $nombre,$telefono,$direccion,$id_comercio;
    public $municipios = [],$departamentos = [],$municipio,$departamento;
    protected $rules = [
        'nombre' => 'required',
        'telefono' => 'required|min:8|max:9',
        'direccion' => 'required',

        'departamento' => 'required',
        'municipio' => 'required',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio',

        'telefono.required' => 'El telefono es obligatorio',
        'telefono.min' => 'Debe contener un mínimo :min de caracteres',
        'telefono.max' => 'Debe conterner un máximo :max de caracteres',

        'direccion.required' => 'La dirección es obligatoria',

        'departamento.required' => 'El departamento es obligatorio',
        'municipio.required' => 'El municipio es obligatorio'

    ];

    protected $listeners = [
        'redirectToComercio',
        'assignComercio',
        'deteleQuestion',
        'deteleComercio'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function redirectToComercio()
    {
        return redirect('/administracion/datos-cliente');
    }


    public function assignComercio($comercio)
    {
        $this->id_comercio = $comercio['id'];
        $this->nombre = $comercio['nombre'];
        $this->telefono = $comercio['telefono'];
        $this->direccion = $comercio['direccion'];
        $this->municipio = $comercio['id_municipio'];

        $this->departamento = Municipio::join('departamentos','departamentos.id','=','municipios.id_departamento')->where('municipios.id',$comercio['id_municipio'])->value('departamentos.id');
    }


    public function createDatoCliente()
    {
        $this->validate();
        try {
            $checkCount = Comercio::count();
            $comercio  = new Comercio;
            $comercio->cod = $checkCount.$this->departamento.$this->municipio;
            $comercio->nombre = $this->nombre;
            $comercio->telefono = $this->telefono;
            $comercio->direccion = $this->direccion;
            $comercio->id_municipio = $this->municipio;
            $comercio->id_usuario = Auth::id();
            $comercio->save();

            $this->alert('success', 'Comercio guardado con éxito ', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectToComercio',
                'confirmButtonText' => 'Continuar',
            ]);
            
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrió un error, intenta nuevamente ', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entedido',
            ]);
        }
    }



    public function updateComercio()
    {
        $this->validate();
        try {
            

            $comercio  = Comercio::where('id',$this->id_comercio)->first();
            $comercio->nombre = $this->nombre;
            $comercio->telefono = $this->telefono;
            $comercio->direccion = $this->direccion;
            $comercio->id_municipio = $this->municipio;
            $comercio->save();

            $this->alert('success', 'Comercio actualizado con éxito ', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectToComercio',
                'confirmButtonText' => 'Continuar',
            ]);
            
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrió un error, intenta nuevamente ', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entedido',
            ]);
        }
    }



    public function deteleQuestion($comercio)
    {
        $this->id_comercio = $comercio;
        $this->alert('question', '¿Eliminar este comercio?', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'deteleComercio',
            'confirmButtonText' => 'SI, Elimininar',
            'showCancelButton' => true,
            'onDismissed' => '',
            'cancelButtonText' => 'Cancelar',
           ]);
    }


    public function deteleComercio()
    {
        $chechPedido = PedidoComercio::where('id_comercio',$this->id_comercio)->count();

        if ($chechPedido > 0) {
            $this->alert('error', 'No puedes eliminar este comercio', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'text' => 'Se encontraron registros relacionados ',
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
            ]);
        } else {
            try {

                Comercio::where('id',$this->id_comercio)->delete();
                $this->alert('success', 'Comercio eliminado con éxito', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => 'redirectToComercio',
                    'confirmButtonText' => 'Entendido',
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
        
    }






    public function render()
    {
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }
        return view('livewire.admin.dato-cliente');
    }
}
