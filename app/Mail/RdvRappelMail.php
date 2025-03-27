<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RdvRappelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $creneau;

    public function __construct($user, $creneau)
    {
        $this->user = $user;
        $this->creneau = $creneau;
    }

    public function build()
    {
        return $this->subject('Confirmation de votre rendez-vous')
                    ->view('emails.rdv_rappel');
    }
}