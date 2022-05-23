<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterComponent extends Component
{
    use LivewireAlert;
    public $name,$email,$password,$password_confirmation;
    
    protected $rules = [
        'name' => 'required|min:10|max:255',
        'email' => 'required|email|min:10|max:255',
        'password' => 'required|min:8|max:255',
        'password_confirmation' => 'required'
    ];


    protected $messages=[
        'name.required'=> 'El nombre es obligatorio',
        'name.min'=> 'El nombre debe contener un minimo de :min caracteres',
        'name.max'=> 'El nombre debe contener un minimo de :max caracteres',
        'email.required'=> 'El correo electrónico es obligatorio',
        'email.min'=> 'El correo electrónico debe contener un minimo de :min caracteres',
        'email.max'=> 'El correo electrónico debe contener un maximo de :max caracteres',
        'email.email'=> 'Correo electrónico no valido',
        'password.required' =>'La contraseña es obligatoria',
        'password.min'=> 'La contraseña debe contener un minimo de :min caracteres',
        'password.max'=> 'La contraseña debe contener un minimo de :max caracteres',
        'password_confirmation.required' => 'La contraseña de confirmación es obligatoria'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function store()
    {

        $this->validate();
        if ($this->password === $this->password_confirmation) {
            $user = new User;
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->id_tipo_usuario = 2;
            $user->save();

            Auth::login($user);
            return redirect('/');


            //login
            /*$credentials = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'id_tipo_usuario' => 2
            ];
     
            if (Auth::attempt($credentials)) {
                session()->regenerate();
     
                return redirect('/');
            }else{
                return redirect('inicio-sesion');
            }*/
    
        } else {

            $this->addError('password_confirmation', 'Las contraseñas no coinciden!');
            
        }
        


    }



    


    public function render()
    {        
        
        return view('livewire.register-component');
    }
}
