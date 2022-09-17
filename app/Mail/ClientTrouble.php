<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientTrouble extends Mailable
{
    use Queueable, SerializesModels;
    public $data, $pedido;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $pedido)
    {
        $this->data = $data;
        $this->pedido = $pedido;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Intento De Entrega')->view('email.client-trouble')->with([
            'data' => $this->data,
            'pedido' => $this->pedido,
        ]);
    }
}
