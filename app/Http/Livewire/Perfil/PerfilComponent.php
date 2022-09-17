<?php

namespace App\Http\Livewire\Perfil;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\{User,Direccion,Pedido};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\URL;

class PerfilComponent extends Component
{
    use LivewireAlert;
    public $name,$old_pass,$new_pass,$email,$edit = 0;

    public $id_direccion,$nombre_direccion,$direccion,$direcciones = [];



    protected $listeners = [
        'asignName',
        'resetName',
        'confirmed',
        'assignDireccion',
        'deleteDireccion'
    ];

    protected $rules = [
        'name' => 'required',
    ];
 
    protected $messages = [
        'name.required' => 'El nombre no pude quedar vacío.',
        'nombre_direccion.required' => 'El nombre de la dirección es obligatoria',
        'direccion.required' => 'La dirección es obligatoria',
    ];
   
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function asignName($name)
    {
        $this->name = $name;
        $this->email = Auth::user()->email;
    }
    public function enableEdit()
    {
        $this->edit = 1;
    }
    

    public function resetName()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['old_pass','new_pass','name','edit']);
    }
    public function confirmed()
    {
        $url = url()->previous();
       return redirect($url);
    }

    public function updateProfileUser()
    {
        $this->validate();
        try {
            if ($this->old_pass <> null && $this->new_pass <> null) {
                if (Hash::check($this->old_pass,Auth::user()->password)) {
                    User::where('id',Auth::id())->update([
                    'name' => $this->name,
                    'password' => Hash::make($this->new_pass)
                    ]);
                    $this->alert('success', 'Perfil actualizado correctamente',[
                        'position' => 'center',
                        'showConfirmButton' => true,
                        'confirmButtonText' => 'Continuar',
                        'onConfirmed' => 'confirmed' 
                    ]);
                }else {
                    $this->addError('all', 'La contraseña anterior proporcionada no coincide con nuestros registros.');
                }
            } else {
                User::where('id',Auth::id())->update([
                    'name' => $this->name,                    
                ]);
                $this->alert('success', 'Perfil actualizado correctamente',[
                    'position' => 'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Continuar',
                    'onConfirmed' => 'confirmed' 
                ]);
            }
        } catch (\Throwable $th) {
            $this->addError('all', 'Ocurrió un error, intenta nuevamente.');
        }       
    }





    public function createAddress()
    {
        $this->validate([
            'nombre_direccion' => 'required',
            'direccion' => 'required',
        ]);
        try {
            $direccion = new Direccion;
            $direccion->nombre = $this->nombre_direccion;
            $direccion->direccion = $this->direccion;
            $direccion->id_usuario = Auth::id();
            $direccion->save();
            $this->alert('success', 'Dirección guardada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
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



    public function deleteQuestion($id)
    {
        $this->id_direccion = $id;
        $this->alert('question', '¿Eliminar esta dirección?', [
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
        try {
            $direccion = Direccion::where('id',$this->id_direccion)->value('direccion');
            $validate = Pedido::where('direccion_recogida',$direccion)->count();
            if ($validate > 0) {
                return  $this->alert('error', 'No puedes eliminar esta dirección', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => '',
                    'confirmButtonText' => 'Entendido',
                ]);
            }else{
                Direccion::where('id',$this->id_direccion)->delete();
                $this->alert('success', 'Dirección eliminada con éxito', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'onConfirmed' => 'confirmed',
                    'confirmButtonText' => 'Continuar',
                ]);
            }            
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


    public function assignDireccion($d)
    {
        $this->id_direccion = $d['id'];
        $this->nombre_direccion = $d['nombre'];
        $this->direccion = $d['direccion'];
    }

    public function updateDireccion()
    {
       
        try {
            Direccion::where('id',$this->id_direccion)->update([
                'nombre' => $this->nombre_direccion,
                'direccion' => $this->direccion
            ]);
            $this->alert('success', 'Dirección actualizada con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'confirmed',
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
        $this->direcciones = Direccion::where('id_usuario',Auth::id())->get();
        return view('livewire.perfil.perfil-component');
    }
}
