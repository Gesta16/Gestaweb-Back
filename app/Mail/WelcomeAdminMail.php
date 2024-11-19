<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $Admin;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Admin, $password)
    {
        $this->Admin = $Admin;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome_admin')
        ->subject('Bienvenido a Gestaweb');
    }
}
