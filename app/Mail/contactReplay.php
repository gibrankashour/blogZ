<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class contactReplay extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $title;
    public $message;
    public $replay;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact, $replay)
    {
        $this->name = $contact->name ;
        $this->title = $contact->title ;
        $this->message = $contact->message ;
        $this->replay = $replay ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.contact-replay');
    }
}
