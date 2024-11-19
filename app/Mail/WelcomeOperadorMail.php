<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeOperadorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $operador;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($superAdmin, $password)
    {
        $this->operador = $superAdmin;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome_operador')
        ->subject('Bienvenido a Gestaweb');
    }
}
