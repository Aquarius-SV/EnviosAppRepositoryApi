<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginComponent extends Component
{
    public $email,$password;


    protected $rules = [
        'email' => 'required|email|min:10',
        'password' => 'required'
    ];
    protected $messages = [
        'email.required' => 'El correo es obligatorio',
        'email.email' => 'Formato de correo electronico no valido',
        'password.required' => 'La contraseña es obligatoria'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function logIn()
    {
       $this->validate();

        $checkUser = User::where('email', '=', $this->email)->select('password')->first();

        if ($checkUser == null) {
            $this->addError('email', 'No hay registros con este correo electronico.');

        }

        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];
        $login = Auth::attempt($credentials);
        
        if ($login == false) {
            $this->addError('password', 'La contraseña es incorrecta.');
        }else {
            
            return redirect('/pedidos');
        }
    }
    public function render()
    {
        return view('livewire.login-component');
    }
}
