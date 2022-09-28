<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusPedido extends Mailable
{
    use Queueable, SerializesModels;
    protected $numero;
    protected $state;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($numero,$state)
    {
        $this->numero = $numero;
        $this->state = $state;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example.pruebas.app@gmail.com', 'Tu pedido No '.$this->numero.' a actualizado su estado')
        ->subject(env('APP_NAME').' - El pedido No '.$this->numero)->view('email.status-pedidos')->with('numero', $this->numero)->with('state',$this->state);
    }
}
