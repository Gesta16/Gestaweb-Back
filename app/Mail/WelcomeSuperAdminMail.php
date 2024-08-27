<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeSuperAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $superAdmin;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($superAdmin, $password)
    {
        $this->superAdmin = $superAdmin;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome_superadmin')
        ->subject('Bienvenido a Gestaweb');
    }
}
