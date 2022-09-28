<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailApi extends Mailable
{
    use Queueable, SerializesModels;
    protected $email;
    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $data)
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com', env('APP_NAME'))
        ->subject('Confirma tú correo electrónico')
        /* ->view('emails.orders.shipped')->with($this->data)->with($this->email); */
        ->markdown('email.api-mail', [
            'url' => $this->data,
            'email' => $this->email 
        ]);
    }
}
