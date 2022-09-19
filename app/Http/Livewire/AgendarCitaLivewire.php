<?php

namespace App\Http\Livewire;

use App\Models\CambioPedido;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AgendarCitaLivewire extends Component
{
    use LivewireAlert;
    public $fecha, $turno, $date, $clientID, $clientEmail, $id_pedido;

    protected $rules = [
        'fecha' => 'required|date',
        'turno' => 'required|min:5|max:6',
        'id_pedido' => 'required'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $validation = $this->validate();

        try {
            $corroborate = CambioPedido::where([
                ['id_pedido', $validation['id_pedido']],
                ['fecha', '!=', null],
                ['turno', '!=', null]
            ])->first();

            if (!$corroborate) {
                CambioPedido::create($validation);
                $this->alert('success', 'Cambio de fecha agendada con éxito.', [
                    'position' => 'center'
                ]);
            } else {
                $this->alert('warning', 'Por favor acude a nuestro punto de reparto para recoger tu paquete.', [
                    'position' => 'center',
                    'timer' => '',
                    'toast' => false,
                    'showConfirmButton' => true,
                    'confirmButtonText' => 'Aceptar',
                    'onConfirmed' => '',
                ]);
            }
        } catch (\Exception $e) {
            $this->alert('error', 'Ocurrió un error inesperado, por favor inténtalo de nuevo.', [
                'position' => 'center',
                'timer' => '',
                'toast' => false,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Aceptar',
                'onConfirmed' => '',
            ]);
        }
    }

    public function render()
    {
        $this->date = now();
        return view('livewire.agendar-cita-livewire');
    }
}
