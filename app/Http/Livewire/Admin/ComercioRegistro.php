<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
class ComercioRegistro extends Component
{

    public $enlace;

    public function generateUrl()
    {
        
        $day = Carbon::now()->addDays(3);

        $this->enlace =  URL::temporarySignedRoute('registro-comercio', $day);

    }

    public function render()
    {
        return view('livewire.admin.comercio-registro');
    }
}
