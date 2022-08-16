<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\{CuentaEliminada, Repartidor};
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Auth;
use DB;

class EliminarCuenta extends Component
{
    use LivewireAlert;

    /* Propiedades */
    public $motivo, $descripcion, $sugerencia;

    /* Reglas de validación */
    protected $rules = [
        'motivo' => 'required|min:5|max:100',
        'descripcion' => 'required|min:10|max:250',
        'sugerencia' => 'nullable|min:4|max:250'
    ];

    /* Valida la propiedad */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /* Elimina la cuenta del usuario desactivando su estado a 0 */
    public function trash() 
    {
        $validatedData = $this->validate();

        try {
            $validatedData['id_usuario'] = auth()->user()->id;
            DB::transaction(function () use($validatedData) {
                CuentaEliminada::create($validatedData);
                DB::table('repartidores')->where('id_usuario', auth()->user()->id)->update(['estado' => 0]);
            });
            $this->alert('success', 'Usuario Eliminado con Éxito', [
                'position' => 'center'
            ]);

            Auth::logout();

            return redirect()->to('/');
        } catch (Exception $e) {
            $this->alert('error', 'Ocurrió un error en el proceso intentalo de nuevo, mas tarde', [
                'position' => 'center'
            ]);
        }
    }

    /* Function de renderizador no eliminar */
    public function render()
    {
        return view('livewire.eliminar-cuenta');
    }
}
