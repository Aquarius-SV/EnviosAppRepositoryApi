<?php

namespace App\Http\Livewire\Correo;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeVerification;
use Illuminate\Support\Facades\Auth;
use App\Models\CodigoVerificacion;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class GeneradorComponent extends Component
{
    use LivewireAlert;
    public $codigo,$nice,$codigo_validator;
    protected  $listeners =['codeGenerator'];
    protected $rules = [
        'codigo_validator' => 'required|numeric|digits_between:6,6'
    ];

    protected $messages = [
        'codigo_validator.required' => 'Codigo de verificación es obligatorio.',
        
        'codigo_validator.digits_between' => 'Codigo de verificación debe contener 6 digitos.',
        'codigo_validator.numeric' => 'Codigo de verificación debe ser numerico.'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

   


    public function codeGenerator()
    {
        $result = '';

        for($i = 0; $i < 6; $i++) {
            $result .= mt_rand(0, 9);
        }
        
        $this->codigo = $result;

        $verifyUserCode = CodigoVerificacion::where('id_usuario',Auth::user()->id)->select('cod')->first();
        if ($verifyUserCode != null) {

            
        }else {
            try {
                $cod = new CodigoVerificacion;
                $cod->cod = $this->codigo;
                $cod->id_usuario = Auth::user()->id;
                $cod->save();
    
    
    
                Mail::to(Auth::user()->email)->send(new CodeVerification($this->codigo));
               /* $this->alert('success', 'Codigo de verificación enviado correctamente', [
                    'position' => 'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Continuar',
                    'timer' => 15000,
                    'onConfirmed' => 'redirectCode',
                ]);*/
                
            } catch (\Throwable $th) {
                $this->addError('all', 'Ocurrió un error al enviar el código de verificación,intenta nuevamente.');
            }
     
        }       
    }


    public function reassingCode()
    {
        $result = '';

        for($i = 0; $i < 6; $i++) {
            $result .= mt_rand(0, 9);
        }
        
        $this->codigo = $result;
        try {
            CodigoVerificacion::where('id_usuario',Auth::user()->id)->update([
                'cod' => $this->codigo
            ]);

            Mail::to(Auth::user()->email)->send(new CodeVerification($this->codigo));
            /*$this->alert('success', 'Codigo de verificación enviado correctamente', [
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'Continuar',
                'timer' => 15000,
                'onConfirmed' => 'redirectCode',
            ]);*/
            
        } catch (\Throwable $th) {
            $this->addError('all', 'Ocurrió un error al enviar el código de verificación,intenta nuevamente.');
        }
    }

    public function codeVerification()
    {
        $this->validate();
        $verifyUserCode = CodigoVerificacion::where('id_usuario',Auth::user()->id)->select('cod')->first();

        if ($verifyUserCode->cod === $this->codigo_validator) {

            try {
                User::where('id',Auth::user()->id)->update([
                    'email_verified_at' => now(),
                ]);
    
                CodigoVerificacion::where('id_usuario',Auth::user()->id)->delete();
                return redirect('/pedidos');

            } catch (\Throwable $th) {
                $this->addError('all', 'Ocurrió un error al verificar el código de verificación,intenta nuevamente.');
            }
            
        }else{
            $this->addError('all', 'Código de verificación incorrecto.');
        }
    }

    


    public function render()
    {
        
        return view('livewire.correo.generador-component');
    }
}
