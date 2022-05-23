<?php

namespace App\Http\Livewire\Notificacion;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class NotificacionComponent extends Component
{
    public  $notificaciones = [];



    public function render()
    {
        $user = Auth::user();
        $this->notificaciones = $user->unreadNotifications;


        return view('livewire.notificacion.notificacion-component');
    }
}
