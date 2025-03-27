<?php
// filepath: /app/Mail/ConfirmationMail.php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.confirmation')
                    ->with([
                        'user' => $this->user,
                        'confirmationUrl' => route('confirmation', ['token' => $this->user->createToken('confirmation')->plainTextToken]),
                    ]);
    }
}