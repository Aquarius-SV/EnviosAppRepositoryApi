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
    public $codigo,$nice;

    protected  $listeners =['redirectCode'];

    public function redirectCode()
    {
        
        return redirect('/verificacion');
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

            try {
                CodigoVerificacion::where('id_usuario',Auth::user()->id)->update([
                    'cod' => $this->codigo
                ]);
    
                Mail::to('diegouriel.martinez15@gmail.com')->send(new CodeVerification($this->codigo));
                $this->alert('success', 'Codigo de verificación enviado correctamente', [
                    'position' => 'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Continuar',
                    'timer' => 15000,
                    'onConfirmed' => 'redirectCode',
                ]);
                
            } catch (\Throwable $th) {
                $this->addError('all', 'Ocurrio un error. intenta nuevamente.');
            }
        }else {
            try {



                $cod = new CodigoVerificacion;
                $cod->cod = $this->codigo;
                $cod->id_usuario = Auth::user()->id;
                $cod->save();
    
    
    
                Mail::to('diegouriel.martinez15@gmail.com')->send(new CodeVerification($this->codigo));
                $this->alert('success', 'Codigo de verificación enviado correctamente', [
                    'position' => 'center',
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Continuar',
                    'timer' => 15000,
                    'onConfirmed' => 'redirectCode',
                ]);
                
            } catch (\Throwable $th) {
                $this->addError('all', 'Ocurrio un error. intenta nuevamente.');
            }
     
        }

       //Auth::user()->email
       
    }

    


    public function render()
    {
        return view('livewire.correo.generador-component');
    }
}
