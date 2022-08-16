<?php

namespace App\Http\Livewire\Perfil;

use Livewire\Component;
use App\Models\DetalleZona;
use App\Models\Zona;
use App\Models\User;
use App\Models\Repartidor;
use App\Models\DatoVehiculo;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DeliveryComponent extends Component
{
    use LivewireAlert;
    public $name,$old_pass,$new_pass,$dui,$nit,$phone,$license,$vehicle,$placa,$vehicle_model,$color,$brand,$peso,$size,$id_repartidor,$usuario;
    public $zonas = [],$deliveryManZones = [],$edit = 0;
    protected $listeners = [
        
        'asignRepartidor',
        'resetDelivery',
        'confirmedDelivery'
    ];


    protected $rules = [
        'name' => 'required|min:10|max:255',
        
        'dui' => 'required|min:8|max:10',
        'nit' => 'required|min:9|max:14',
        'phone' => 'required|min:8|max:9',
        'license' => 'required|min:9|max:14',
        
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
    public function enabledEdit()
    {
        $this->edit = 1;
    }

    public function asignRepartidor($id)
    {
        $repartidor = User::join('repartidores','repartidores.id_usuario','=','users.id')
        ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')->select('users.name','repartidores.id as id_repartidor','repartidores.telefono','repartidores.dui',
        'repartidores.nit','repartidores.licencia','datos_vehiculos.tipo','datos_vehiculos.placa','datos_vehiculos.marca','datos_vehiculos.color',
        'datos_vehiculos.peso','datos_vehiculos.size','datos_vehiculos.modelo')->where('users.id',$id)->first();

        $this->name = $repartidor->name;
        $this->dui = $repartidor->dui;

        
        $newdui = substr_replace($repartidor->dui, '-', 7, 0);
        $this->dui = $newdui;

        $this->nit = $repartidor->nit;
        
        $newtele = substr_replace($repartidor->telefono, '-', 4, 0);
        $this->phone = $newtele;
        $this->license = $repartidor->licencia;
        $this->vehicle = $repartidor->tipo;
        $this->placa = $repartidor->placa;
        $this->vehicle_model = $repartidor->modelo;
        $this->color = $repartidor->color;
        $this->brand = $repartidor->marca;
        $this->peso = $repartidor->peso;
        $this->size = $repartidor->size;
        $this->id_repartidor = $repartidor->id_repartidor;
    }

    public function resetDelivery()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['old_pass','new_pass','name','dui','nit','phone','license','vehicle','placa','vehicle_model','color','brand','peso','size']);
    }
    public function confirmedDelivery()
    {
        $url = url()->previous();
       return redirect($url);
    }

    public function updateProfileDelivery()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            if ($this->old_pass <> null && $this->new_pass <> null) {
                if (Hash::check($this->old_pass,Auth::user()->password)) {  
                    User::where('id',Auth::id())->update([
                        'name' => $this->name,
                        'password' => Hash::make($this->new_pass),
    
                        ]);           
                }else {
                    $this->addError('all', 'La contraseña anterior proporcionada no coincide con nuestros registros.');
                }
            }else {
                User::where('id',Auth::id())->update([
                    'name' => $this->name                
                ]);
            }
                   
            Repartidor::where('id',$this->id_repartidor)->update([
                'telefono' => $this->phone,
                'dui' => $this->dui,
                'nit' => $this->nit,
                'licencia' => $this->license    
            ]);

            DatoVehiculo::where('id_user',Auth::user()->id)->update([
                'tipo' => $this->vehicle,
                'placa' => $this->placa,
                'modelo' => $this->vehicle_model,
                'marca' => $this->brand,
                'color' => $this->color,
                'peso' => $this->peso,
                'size' => $this->size
            ]);
            DB::commit();
            $this->alert('success', 'Perfil actualizado correctamente',[
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Continuar',
                'onConfirmed' => 'confirmedDelivery' 
            ]);
            
            
        } catch (\Throwable $th) {
           
           $this->alert('success', 'Ocurrió un error, intenta nuevamente.',[
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => 'Continuar',            
            ]);
            DB::rollBack();
        }
    }



    public function render()
    {
        $repartidor = User::join('repartidores','repartidores.id_usuario','=','users.id')
        ->join('datos_vehiculos','datos_vehiculos.id_user','=','users.id')->select('repartidores.id as id_repartidor')->where('users.id',$this->usuario)->first();
        $this->deliveryManZones = DetalleZona::join('zonas','zonas.id','=','detalles_zonas.id_zona')
        ->where('id_repartidor',$repartidor->id_repartidor)->select('zonas.id as zone_id','zonas.nombre')->get();
        $arrayZonas = [];
        foreach ($this->deliveryManZones as $zone) {
          $arrayZonas[] = $zone->zone_id;
        }
        $this->zonas = Zona::whereNotIn('id',$arrayZonas)->select('zonas.id','zonas.nombre')->get();

        
        return view('livewire.perfil.delivery-component');
    }
}
