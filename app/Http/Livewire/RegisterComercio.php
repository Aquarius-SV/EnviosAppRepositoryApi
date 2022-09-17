<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Hash;
use App\Models\{User,Comercio,Departamento,Municipio};
use DB;

class RegisterComercio extends Component
{
    use LivewireAlert;
    public $name,$email,$password,$password_confirmation,$telefono,$telefono_comercio,$comercio,$dui,$direccion;
    public $municipios = [],$departamentos = [],$municipio,$departamento;
    protected $rules = [
        'name' => 'required|min:10|max:255',
        'email' => 'required|email|min:10|max:255',
        'password' => 'required|min:8|max:255',
        'password_confirmation' => 'required',

        'telefono' => 'required|min:8|max:9',
        'telefono_comercio' => 'required|min:8|max:9',
        'comercio' => 'required',
        'dui' => 'required|min:9|max:10',
        'direccion' => 'required',

        'departamento' => 'required',
        'municipio' => 'required',
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
        'password_confirmation.required' => 'La contraseña de confirmación es obligatoria',


        'telefono.required' => 'El número de teléfono es obligatorio',
        'telefono.min' => 'El número de teléfono debe contener un mínimo de :min caracteres',
        'telefono.max' => 'El número de teléfono debe contener un máximo de :max caracteres',

        'telefono_comercio.required' => 'El número de teléfono es obligatorio',
        'telefono_comercio.min' => 'El número de teléfono debe contener un mínimo de :min caracteres',
        'telefono_comercio.max' => 'El número de teléfono debe contener un máximo de :max caracteres',

        'comercio.required' => 'El nombre del comercio es obligatorio', 

        'dui.required' => 'El DUI es obligatorio',
        'dui.min'=> 'El DUI debe contener un mínimo de :min caracteres',
        'dui.max'=> 'El DUI debe contener un máximo de :max caracteres',

        'direccion.required' => 'La dirección del comercio es obligatoria',
        'departamento.required' => 'El departamento es obligatorio',
        'municipio.required' => 'El municipio es obligatorio'
         
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function sameTel()
    {
        $this->telefono_comercio = $this->telefono;
    }
    public function store()
    {

        $this->validate();
        if ($this->password === $this->password_confirmation) {
            $checkUser = User::where('email', '=', $this->email)->select('password','estado')->first();

            if ($checkUser <>  null) {
                $this->addError('email', 'Ya existe una cuenta con este correo electrónico.');
    
            }else {
                
                try {
                    DB::beginTransaction();
                    $user = new User;
                    $user->name = $this->name;
                    $user->email = $this->email;
                    $user->password = Hash::make($this->password);
                    $user->id_tipo_usuario = 2;
                    $user->save();


                    $checkCount = Comercio::count();
                    $comercio  = new Comercio;
                    $comercio->cod = $checkCount.$this->departamento.$this->municipio;
                    $comercio->nombre = $this->comercio;
                    $comercio->telefono = $this->telefono_comercio;
                    $comercio->telefono_encargado = $this->telefono;
                    $comercio->dui = $this->dui;
                    $comercio->id_usuario = $user->id;
                    $comercio->direccion = $this->direccion;
                    $comercio->save();
                    DB::commit();
                    Auth::login($user);
                return redirect('/pedidos');
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $this->addError('email', 'Ocurrió un error, intenta nuevamente.');
                }
               
            }                        
        } else {

            $this->addError('password_confirmation', '¡Las contraseñas no coinciden!');
            
        }        
    }
    public function render()
    {
        $this->departamentos = Departamento::get();
        if ($this->departamento) {
            $this->municipios = Municipio::where('id_departamento',$this->departamento)->get();
        }
        return view('livewire.register-comercio');
    }
}
