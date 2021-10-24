<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class send_mail extends Mailable
{
    use Queueable, SerializesModels;

    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject("Web & Crafts Account Password")->markdown('send_mail')->with(["password" => $this->password]);
    }
}
