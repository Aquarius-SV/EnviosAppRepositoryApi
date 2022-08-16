<?php

namespace App\Http\Livewire\Perfil;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\URL;

class PerfilComponent extends Component
{
    use LivewireAlert;
    public $name,$old_pass,$new_pass,$email,$edit = 0;

    protected $listeners = [
        'asignName',
        'resetName',
        'confirmed'
    ];

    protected $rules = [
        'name' => 'required',
    ];
 
    protected $messages = [
        'name.required' => 'El nombre no pude quedar vacío.',
        
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


    

    public function render()
    {
        
        return view('livewire.perfil.perfil-component');
    }
}
