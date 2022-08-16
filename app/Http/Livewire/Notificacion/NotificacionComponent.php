<?php

namespace App\Http\Livewire\Notificacion;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class NotificacionComponent extends Component
{
    public  $notificaciones = [];



    public function markReadNotification()
    {

        $user = User::where('id',Auth::id())->select('users.*')->first();
        $user->unreadNotifications->markAsRead();

    }



    public function render()
    {
        $user = Auth::user();
        $this->notificaciones = $user->unreadNotifications;


        return view('livewire.notificacion.notificacion-component');
    }
}
