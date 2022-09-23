<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\{Comercio,PedidoComercio,Departamento,Municipio,Direccion};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
class DatoCliente extends Component
{
    use LivewireAlert;
    public $nombre,$telefono,$direccion,$id_comercio,$encargado,$tel_encargado,$dui;
    public $municipios = [],$departamentos = [],$municipio,$departamento;
    public $direccion_recogida,$nombre_direccion_recogida,$comercio,$direcciones_comercios = [],$nombre_comercio,$id_direccion_comercio;
   

    protected $rules = [
        'nombre' => 'required',
        'encargado' => 'required',

        'telefono' => 'required|min:8|max:9',
        'tel_encargado' => 'required|min:8|max:9',

        'direccion' => 'required',
        'dui' => 'required|min:9|max:10',
        
        'departamento' => 'required',
        'municipio' => 'required',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio',
        'encargado.required' => 'El nombre es obligatorio',

        'telefono.required' => 'El telefono es obligatorio',
        'telefono.min' => 'Debe contener un mínimo :min de caracteres',
        'telefono.max' => 'Debe conterner un máximo :max de caracteres',

        'tel_encargado.required' => 'El telefono es obligatorio',
        'tel_encargado.min' => 'Debe contener un mínimo :min de caracteres',
        'tel_encargado.max' => 'Debe conterner un máximo :max de caracteres',

        'direccion.required' => 'La dirección es obligatoria',

        'departamento.required' => 'El departamento es obligatorio',
        'municipio.required' => 'El municipio es obligatorio',

        'dui.required' => 'El DUI es obligatorio',
        'dui.min'=> 'El DUI debe contener un mínimo de :min caracteres',
        'dui.max'=> 'El DUI debe contener un máximo de :max caracteres',

        'nombre_direccion_recogida.required' => 'El nombre es obligatorio',

        'direccion_recogida.required' => 'La dirección es obligatoria',

    ];

    protected $listeners = [
        'redirectToComercio',
        'assignComercio',
        'deteleQuestion',
        'deteleComercio',
        'assignComercioToDireccion',
        'assignDireccionComercio',
        'resetDatosComercio',
        'resetDataDirecciones'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function redirectToComercio()
    {
        return redirect('/administracion/datos-cliente');
    }

    public function resetDatosComercio()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['nombre','telefono','id_comercio','encargado','tel_encargado','dui','municipio','departamento','direccion']);
    }

    public function resetDataDirecciones()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['direccion_recogida','nombre_direccion_recogida','comercio','nombre_comercio','id_direccion_comercio']);
    }

    public function assignComercio($comercio)
    {
        $this->id_comercio = $comercio['id'];
        $this->nombre = $comercio['nombre'];
        $this->telefono = $comercio['telefono'];
        $this->direccion = $comercio['direccion'];
        $this->municipio = $comercio['id_municipio'];

        $this->encargado = $comercio['nombre_encargado'];
        $this->tel_encargado = $comercio['telefono_encargado'];
        $this->dui = $comercio['dui'];

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
            $comercio->dui = $this->dui;
            $comercio->nombre_encargado = $this->encargado;
            $comercio->telefono_encargado = $this->tel_encargado;
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
            $comercio->dui = $this->dui;
            $comercio->nombre_encargado = $this->encargado;
            $comercio->telefono_encargado = $this->tel_encargado;
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

    public function assignComercioToDireccion($comercio)
    {
        $this->comercio = $comercio['id'];
        $this->nombre_comercio = $comercio['nombre'];
    }

    public function assignDireccionComercio($dr)
    {
        $this->nombre_direccion_recogida = $dr['nombre'];
        $this->direccion_recogida = $dr['direccion'];
        $this->id_direccion_comercio = $dr['id'];
    }

    public function DireccioneRecogida()
    {
        $this->validate([
            'direccion_recogida' => 'required',
            'nombre_direccion_recogida' => 'required',
        ]);

        try {


            if ($this->id_direccion_comercio) {
                $direccion = Direccion::where('id',$this->id_direccion_comercio)->first();
                $direccion->nombre  = $this->nombre_direccion_recogida;
                $direccion->direccion = $this->direccion_recogida;                             
                $direccion->save();
            }else{
                $direccion = new Direccion;
                $direccion->nombre  = $this->nombre_direccion_recogida;
                $direccion->direccion = $this->direccion_recogida;
                $direccion->id_comercio = $this->comercio;
                $direccion->id_usuario = Auth::id();
                $direccion->save();
            }


           $title = ($this->id_direccion_comercio) ? 'actualizada' : 'guardada' ;

           $this->alert('success', 'Dirección de recogida '.$title.' con éxito', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'redirectToComercio',
            'confirmButtonText' => 'Continuar',
           ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrió un error inesperado, intenta nuevamente', [
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
           $this->direcciones_comercios = Direccion::where('id_comercio',$this->comercio)->get();
        }
        return view('livewire.admin.dato-cliente');
    }
}
