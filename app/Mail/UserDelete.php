<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserDelete extends Mailable
{
    use Queueable, SerializesModels;
    public $razon;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($razon)
    {
        $this->razon = $razon;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example.pruebas.app@gmail.com', 'Tu cuenta fue eliminida')
        ->subject(env('APP_NAME').' - Cuenta eliminada.')->view('email.delete-user')->with('razon', $this->razon);
    }
}
