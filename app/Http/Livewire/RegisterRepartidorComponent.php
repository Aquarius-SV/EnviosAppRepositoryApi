<?php

namespace App\Http\Livewire;

use App\Models\DetalleZona;
use App\Models\Repartidor;
use App\Models\Zona;
use App\Models\User;
use App\Models\DatoVehiculo;;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegisterRepartidorComponent extends Component
{
    public $name, $email, $password, $confirm_password, $dui, $nit, $phone, $license, $zones = [],$vehicle,$vehicle_model,$placa,$brand,$color,$peso,$size;
    public $zonaList = [];

    protected $rules = [
        'name' => 'required|min:10|max:255',
        'email' => 'required|email|min:10|max:255',
        'password' => 'required|min:8|max:255',
        'confirm_password' => 'required',
        'dui' => 'required|min:8|max:9',
        'nit' => 'required|min:9|max:14',
        'phone' => 'required|min:8|max:9',
        'license' => 'required|min:9|max:12',
        'zones.*' => 'required',
        'vehicle' => 'required|min:4|max:45',
        'placa' => 'required|min:3|max:7',
        'vehicle_model' => 'required|min:6|max:45',
        'brand' => 'required|min:4|max:45',
        'color' => 'required|min:4|max:45',
        'peso' => 'required|min:4',
        'size' => 'required|min:4',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio',
        'name.min' => 'El nombre debe contener un minimo de :min caracteres',
        'name.max' => 'El nombre debe contener un minimo de :max caracteres',

        'email.required' => 'El correo electrónico es obligatorio',
        'email.min' => 'El correo electrónico debe contener un minimo de :min caracteres',
        'email.max' => 'El correo electrónico debe contener un maximo de :max caracteres',
        'email.email' => 'Correo electrónico no valido',

        'password.required' => 'La contraseña es obligatoria',
        'password.min' => 'La contraseña debe contener un minimo de :min caracteres',
        'password.max' => 'La contraseña debe contener un maximo de :max caracteres',

        'confirm_password.required' => 'La contraseña de confirmación es obligatoria',

        'dui.required' => 'El numero de DUI es obligatorio',
        'dui.min' => 'El numero de DUI debe contener un minimo de :min caracteres',
        'dui.max' => 'El numero de DUI debe contener un maximo de :max caracteres',

        'nit.required' => 'El numero de NIT es obligatorio',
        'nit.min' => 'El numero de NIT debe contener un minimo de :min caracteres',
        'nit.max' => 'El numero de NIT debe contener un maximo de :max caracteres',

        'phone.required' => 'El numero de telefono es obligatorio',
        'phone.min' => 'El numero de telefono debe contener un minimo de :min caracteres',
        'phone.max' => 'El numero de telefono debe contener un maximo de :max caracteres',

        'license.required' => 'El numero de licencia es obligatorio',
        'license.min' => 'El numero de licencia debe contener un minimo de :min caracteres',
        'license.max' => 'El numero de licencia debe contener un maximo de :max caracteres',
        'license.numeric' => 'Numero de licencia no valido',

        'zones.*.required' => 'La zona de trabajo es obligatoria',


        'vehicle.required' => 'El tipo de vehiculo es obligatorio',
        'vehicle.min' => 'El tipo de vehiculo debe contener un minimo de :min caracteres',
        'vehicle.max' => 'El tipo de vehiculo debe contener un maximo de :max caracteres',

        'placa.required' => 'El numero de placa del vehiculo es obligatorio',
        'placa.min' => 'El numero de placa del vehiculo debe contener un minimo de :min caracteres',
        'placa.max' => 'El numero de placa del vehiculo debe contener un maximo de :max caracteres',


        'vehicle_model.required' => 'El modelo del vehiculo es obligatorio',
        'vehicle_model.min' => 'El modelo del vehiculo debe contener un minimo de :min caracteres',
        'vehicle_model.max' => 'El modelo del vehiculo debe contener un maximo de :max caracteres',

        'color.required' => 'El color del vehiculo es obligatorio',
        'color.min' => 'El color del vehiculo debe contener un minimo de :min caracteres',
        'color.max' => 'El color del vehiculo debe contener un maximo de :max caracteres',

        'brand.required' => 'La marca del vehiculo es obligatoria',
        'brand.min' => 'La marca del vehiculo debe contener un minimo de :min caracteres',
        'brand.max' => 'La marca del vehiculo debe contener un maximo de :max caracteres',

        'peso.required' => 'El peso máximo del vehiculo es obligatorio',
        'peso.min' => 'El color del vehiculo debe contener un minimo de :min caracteres',

        'size.required' => 'El tamaño máximo con cual el vehiculo puede cargar es obligatorio',
        'size.min' => 'El tamaño máximo con cual el vehiculo puede cargar debe contener un minimo de :min caracteres',
        
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedConfirmPassword()
    {
        if ($this->password != $this->confirm_password) {
            $this->addError('confirm_password', 'Las contraseñas no coinciden!');
        }
    }

    public function store()
    {
        

        $this->validate();
        if ($this->password === $this->confirm_password) {

            try {
                DB::beginTransaction();

                $user = new User;
                $user->name = $this->name;
                $user->email = $this->email;
                $user->password = Hash::make($this->password);
                $user->id_tipo_usuario = 3;
                $user->save();

                $repartidor = new Repartidor();
                $repartidor->dui = $this->dui;
                $repartidor->nit = $this->nit;
                $repartidor->telefono = $this->phone;
                $repartidor->licencia = $this->license;
                $repartidor->id_usuario = $user->id;
                $repartidor->save();

                $datoVehiculo = new DatoVehiculo;
                $datoVehiculo->tipo = $this->vehicle;
                $datoVehiculo->placa = $this->placa;
                $datoVehiculo->modelo = $this->vehicle_model;
                $datoVehiculo->marca = $this->brand;
                $datoVehiculo->color = $this->color;
                $datoVehiculo->id_user = $user->id;
                $datoVehiculo->peso = $this->peso;
                $datoVehiculo->size = $this->size;
                $datoVehiculo->save();
              
                foreach ($this->zones as $z ) {
                    $detalle = new DetalleZona;
                    $detalle->id_repartidor = $repartidor->id;
                    $detalle->id_zona = $z;
                    $detalle->save();
                }
                DB::commit();
                $credentials = [
                    'email' => $this->email,
                    'password' => $this->password
                ];
                Auth::attempt($credentials);
                return redirect('/registro-repartidor');  

                
            } catch (\Throwable $th) {
               $this->addError('error-all', $th->getMessage());

                DB::rollBack();
            }                      
           
    
        } else {

            $this->addError('password_confirmation', 'Las contraseñas no coinciden!');
            
        }
                                                  
    }

    public function render()
    {
        $this->zonaList = Zona::where('estado', 1)->select('nombre', 'id as id_zona')->get();
        return view('livewire.register-repartidor-component');
    }
}
