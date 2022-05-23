<?php

namespace App\Http\Livewire\Correo;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\CodigoVerificacion;
use App\Models\User;

class VerificacionComponent extends Component
{
    public $codigo;


    protected $rules = [
        'codigo' => 'required|numeric|digits_between:6,6'
    ];

    protected $messages = [
        'codigo.required' => 'Codigo de verificación es obligatorio.',
        
        'codigo.digits_between' => 'Codigo de verificación debe contener 6 digitos.',
        'codigo.numeric' => 'Codigo de verificación debe ser numerico.'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }



    public function codeVerification()
    {
        $this->validate();
        $verifyUserCode = CodigoVerificacion::where('id_usuario',Auth::user()->id)->select('cod')->first();

        if ($verifyUserCode->cod === $this->codigo) {

            try {
                User::where('id',Auth::user()->id)->update([
                    'email_verified_at' => now(),
                ]);
    
                CodigoVerificacion::where('id_usuario',Auth::user()->id)->delete();
                return redirect('/pedidos');

            } catch (\Throwable $th) {
                $this->addError('all', 'Ocurrio un error. intenta nuevamente.');
            }
            
        }else{
            $this->addError('all', 'Codigo de verificación incorrecto.');
        }
    }
   
    public function render()
    {
        return view('livewire.correo.verificacion-component');
    }
}
