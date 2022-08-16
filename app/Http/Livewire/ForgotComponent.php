<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPassword;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;

class ForgotComponent extends Component
{
    use LivewireAlert;
    public $email;

    protected $listeners = [
        'toHome'
    ];
    protected $rules = [
        'email' => 'required|email',
        
    ];

    protected $messages = [
        'email.required' => 'El correo electrónico es obligatorio',
        'email.email' => 'Formato de correo electrónico no valido'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function toHome()
    {
        return redirect('/');
    }
    public function verifyEmailPassword()
    {

        $this->validate();
        $emailVerify = User::where('email', '=', $this->email)->select('id','email')->first();

        
        if ($emailVerify != null) {
            $url = URL::temporarySignedRoute(
                'restablecimiento', now()->addMinutes(5), ['user' => $emailVerify->id]
            );
            Mail::to($this->email)->send(new ForgotPassword($url));

            $this->alert('success', 'Se a enviado un link de restablecimiento de tu contraseña a tu correo electrónico.',[
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Aceptar',
                'onConfirmed' => 'toHome',
                'timer' => '10000'
            ]);




        }else {
            $this->alert('warning', 'El correo electronico no coincide con ninguno de nuestros registros.', [
                'position' => 'center',
                'timer' => '10000'
            ]);
            

        }
        
    }

    public function render()
    {
        return view('livewire.forgot-component');
    }
}
