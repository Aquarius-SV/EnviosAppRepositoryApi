<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Hash;
use App\Models\{User,DatoIntermediario,DetallePuntoReparto};
use DB;

class IntermediarioRegistro extends Component
{
    public $nombre,$dui,$telefono,$direccion,$cargo,$email,$password,$confirm_password;
    public $punto;

    protected $rules = [
        'nombre' => 'required|min:10|max:255',
        'email' => 'required|email|min:10|max:255',
        'password' => 'required|min:8|max:255',
        'confirm_password' => 'required',

        'telefono' => 'required|min:8|max:9',
        'direccion' => 'required|min:10|max:255',
        'cargo' => 'nullable',
        'dui' => 'required|min:9|max:10',
    ];


    protected $messages=[
        'nombre.required'=> 'El nombre es obligatorio',
        'nombre.min'=> 'El nombre debe contener un mínimo de :min caracteres',
        'nombre.max'=> 'El nombre debe contener un mínimo de :max caracteres',
        'email.required'=> 'El correo electrónico es obligatorio',
        'email.min'=> 'El correo electrónico debe contener un mínimo de :min caracteres',
        'email.max'=> 'El correo electrónico debe contener un máximo de :max caracteres',
        'email.email'=> 'Correo electrónico no valido',
        'password.required' =>'La contraseña es obligatoria',
        'password.min'=> 'La contraseña debe contener un mínimo de :min caracteres',
        'password.max'=> 'La contraseña debe contener un máximo de :max caracteres',
        'confirm_password.required' => 'La contraseña de confirmación es obligatoria',


        'telefono.required' =>'El número de teléfono es obligatoria',
        'telefono.min' =>'El número de teléfono debe contener un mínimo de :min de caracteres',
        'telefono.max' =>'El número de teléfono debe contener un máximo de :max de caracteres',
        

        'direccion.required' =>'La dirección de residencia es obligatoria',
        'direccion.min' => 'La dirección de residencia debe contener un mínimo de :min caracteres',
        'direccion.max' => 'La dirección de residencia debe contener un máximo de :max caracteres',

        'dui.required' => 'El DUI es obligatorio',
        'dui.min' =>'El DUI debe contener un mínimo de :min caracteres',
        'dui.max' => 'El DUI debe contener un máximo de :max caracteres',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {

        $this->validate();
        
        if ($this->password === $this->confirm_password) {
            $checkUser = User::where('email', '=', $this->email)->select('password','estado')->first();

            if ($checkUser <>  null) {
                $this->addError('email', 'Ya existe una cuenta con este correo electrónico.');
    
            }else {
                try {
                DB::beginTransaction();
                $user = new User;
                $user->name = $this->nombre;
                $user->email = $this->email;
                $user->password = Hash::make($this->password);
                $user->id_tipo_usuario = 5;
                $user->save();

                $datos = new DatoIntermediario;
                $datos->id_usuario = $user->id;
                $datos->dui = $this->dui;
                $datos->direccion = $this->direccion;
                $datos->telefono = $this->telefono;
                $datos->cargo = $this->cargo;
                $datos->save();

                $detalle = new DetallePuntoReparto;
                $detalle->id_punto_reparto = $this->punto;
                $detalle->id_usuario = $user->id;
                $detalle->save();
                
                DB::commit();
    
                Auth::login($user);
                return redirect('/puntos-repartos');
                } catch (\Throwable $th) {
                    DB::rollBack();
                    $this->addError('email', 'Ocurrió un error, intenta nuevamente.');
                }
               
            }                        
        } else {

            $this->addError('password_confirmation', 'Las contraseñas no coinciden!');
            $this->addError('password', 'Las contraseñas no coinciden!');
            
        }        
    }
    

    public function render()
    {
        return view('livewire.intermediario-registro');
    }
}
