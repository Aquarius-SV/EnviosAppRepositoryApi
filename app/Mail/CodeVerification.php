<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeVerification extends Mailable
{
    use Queueable, SerializesModels;
    protected $codigo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example.pruebas.app@gmail.com', 'Codigo de Verificación')
        ->subject('Tu codigo de verificación')->view('email.cod-verification')->with('codigo', $this->codigo);
    }
}
