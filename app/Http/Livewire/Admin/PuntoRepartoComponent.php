<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\{PuntoReparto,Municipio,Departamento,PedidoPunto};
use Jantinnerezo\LivewireAlert\LivewireAlert;
class PuntoRepartoComponent extends Component
{
    use LivewireAlert;
    public $nombre,$direccion,$telefono,$departamento,$municipio,$punto,$empresa,$correo_empresa,$nombre_propietario;
    public $municipios = [],$departamentos = [];
    public $dep_nombre,$mun_nombre;

    protected $listeners = [
        'redirectPunto',
        'assignReparto',
        'resetPuntoVars',
        'questionDisablePunto',
        'disablePunto',
        'activePunto',        
        'questionDeletePunto',
        'deletePunto',
    ];

    protected $rules = [
        'nombre' => 'required|min:10|max:255',
        'direccion' => 'required|min:20|max:255',
        'telefono' => 'required|min:8|max:9',
        'departamento' => 'required',
        'municipio' => 'required',
        'empresa' => 'nullable',
        'correo_empresa' => 'nullable|email',
        'nombre_propietario' => 'nullable',
        
    ];
    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min' => 'El nombre debe contener un mínimo de :min caracteres.',
        'nombre.max' => 'El nombre debe contener un máximo de :max caracteres.', 
        
        'direccion.required' => 'La dirección es obligatoria',
        'direccion.min' => 'La dirección debe contener un mínimo de :min caracteres',
        'direccion.max' => 'La dirección debe contener un máximo de :max caracteres',


        'telefono.required' => 'El teléfono es obligatorio',
        'telefono.min' => 'El teléfono debe contener un minimo de :min caracteres',
        'telefono.max' => 'El teléfono debe contener un máximo de :max caracteres',

        'departamento.required' => 'El departamento es obligatorio',
        'municipio.required' => 'El municipio es obligatorio',

        'correo_empresa.mail' => 'Formato no valido'
    ];

    public function redirectPunto()
    {
        return redirect('/administracion/puntos-de-reparto');
    }

    public function savePunto()
    {
        $this->validate();
        $count = PuntoReparto::where('id_municipio',$this->municipio)->count();
        try {            
            $punto = new PuntoReparto;
            $punto->nombre = $this->nombre;
            $punto->direccion = $this->direccion;
            $punto->telefono = $this->telefono;
            $punto->id_municipio  = $this->municipio;
            $punto->correo_empresarial = $this->correo_empresa;
            $punto->nombre_empresa = $this->empresa;
            $punto->nombre_propietario = $this->nombre_propietario;
            $punto->codigo =  ($count > 9) ? $this->departamento.$this->municipio.$count+1 : $this->departamento.$this->municipio."0".$count+1 ;
            $punto->save();
            $this->alert('success', 'Punto de reparto guardado con éxito ', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectPunto',
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


    public function assignReparto($pedido)
    {
        $this->nombre = $pedido['nombre'];
        $this->direccion = $pedido['direccion'];
        $this->telefono = $pedido['telefono'];
        $this->departamento = Departamento::join('municipios','municipios.id_departamento','=','departamentos.id')->where('municipios.id',$pedido['id_municipio'])->value('departamentos.id');
        $this->municipio = $pedido['id_municipio'];        
        $this->punto = $pedido['id'];
        $this->empresa = $pedido['nombre_empresa'];
        $this->correo_empresa = $pedido['correo_empresarial'];
        $this->nombre_propietario = $pedido['nombre_propietario'];
        
        $dataRegion = Departamento::join('municipios','municipios.id_departamento','=','departamentos.id')
        ->where('municipios.id',$pedido['id_municipio'])->select('departamentos.nombre as departamento','municipios.nombre as municipio')->first();

        $this->dep_nombre =  $dataRegion->departamento;
        $this->mun_nombre =  $dataRegion->municipio;
    }

    public function resetPuntoVars()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['nombre','direccion','telefono','municipio','departamento','punto']);
    }


    public function updatePunto()
    {
        $this->validate();
        try {

            PuntoReparto::where('id',$this->punto)->update([
                'nombre' => $this->nombre,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono,
                'id_municipio' => $this->municipio,                
            ]);
            $this->alert('success', 'Punto de reparto actualizado con éxito ', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectPunto',
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

    public function questionDisablePunto($punto)
    {
        $this->punto = $punto;
        
        $this->alert('question', '¿Desactivar este punto de reparto?', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'disablePunto',
            'showCancelButton' => true,
            'onDismissed' => '',
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Si, desactivar',
           ]);
    }

    public function disablePunto()
    {
        try {
            PuntoReparto::where('id',$this->punto)->update([
                'estado' => 0
            ]);
            $this->alert('success', 'Punto de reparto desactivado con éxito ', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectPunto',
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

    public function activePunto($punto)
    {
        
        try {
            PuntoReparto::where('id',$punto)->update([
                'estado' => 1
            ]);
            $this->alert('success', 'Punto de reparto activado con éxito ', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectPunto',
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


    public function questionDeletePunto($punto)
    {
        $this->punto = $punto;
        $this->alert('question', '¿Eliminar este punto de reparto?', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => 'deletePunto',
            'showCancelButton' => true,
            'onDismissed' => '',
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Si, eliminar',
           ]);
    }



    public function deletePunto()
    {
        $check = PedidoPunto::where('id_punto',$this->punto)->count();
        if ($check > 0) {
           return $this->alert('error', 'No puedes eliminar este punto de reparto, por que hay datos relacionados.', [
            'position' => 'center',
            'timer' => '',
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'showCancelButton' => false,
            'onDismissed' => '',
            'confirmButtonText' => 'Entendido',
           ]);
        } else {
            try {
                PuntoReparto::where('id',$punto)->delete();
                $this->alert('success', 'Punto de reparto eliminado con éxito ', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => 'redirectPunto',
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
        
    }




    public function render()
    {
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }
        

        return view('livewire.admin.punto-reparto-component');
    }
}
