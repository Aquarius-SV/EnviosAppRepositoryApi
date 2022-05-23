<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;

class NewPasswordComponent extends Component
{
    use LivewireAlert;
    public $password,$confirm_password,$id_user;

    protected $listeners = [
        'toLogin'
    ];
    protected $rules = [
        'password' => 'required',
        'confirm_password' => 'required'
    ];

    protected $messages = [
        'password.required' => 'La contraseña es obligatoria',
        'password.confirm_password' => 'La contraseña es obligatoria'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function toLogin()
    {
        return redirect('/inicio-sesion');
    }

    public function saveNewPassword()
    {
        $this->validate();
        
        try {
            User::where('id',$this->id_user)->update([
                'password' => Hash::make($this->password)
            ]);
            $this->alert('success', 'Contraseña actualizada.',[
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Continuar',
                'onConfirmed' => 'toLogin',
                'allowOutsideClick' => false,
                'allowEscapeKey' => false,
                'allowEnterKey' => false,

            ]);
            
        } catch (\Throwable $th) {
            $this->alert('warning', 'Ocurrió un error, intenta nuevamente!',[
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Aceptar',   
            ]);
            
        }


        
    }

    public function render()
    {
        return view('livewire.new-password-component');
    }
}
