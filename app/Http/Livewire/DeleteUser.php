<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserDelete;

class DeleteUser extends Component
{

    use LivewireAlert;
    public $user,$razon;


    protected  $rules = [
        'razon' =>'required',
    ];

    protected $messages = [
        'razon.required' =>'La razón es obligatoria'
    ];

    protected $listeners = [
        'assingUser',
        'redirectRepartidor'
    ];

    public function redirectRepartidor()
    {
        return redirect('/administracion/repartidores');
    }

    public function assingUser($user)
    {
        $this->user = $user;
    }




    public function deleteUser()
    {
        $this->validate();
        try {
            $emial = User::where('id',$this->user)->value('email');
            User::where('id',$this->user)->updated([
                'estado' => 0
            ]);
            Mail::to($emial)->send(new UserDelete($this->razon));
            $this->alert('success', 'Usuario eliminado con éxito', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => 'redirectRepartidor',
                'confirmButtonText' => 'Continuar',
               ]);
        } catch (\Throwable $th) {
            $this->alert('error', 'Ocurrió un error, intenta nuevamente', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Entendido',
            ]);
        }
        
    }



    public function render()
    {
        return view('livewire.delete-user');
    }
}
