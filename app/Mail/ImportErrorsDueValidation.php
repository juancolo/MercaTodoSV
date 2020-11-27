<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ImportErrorsDueValidation extends Mailable
{
    use Queueable, SerializesModels;

    private $errors;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($errors, $user)
    {
        $this->errors = $errors;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $errors = $this->errors;
        return $this
            ->to($this->user)
            ->markdown('email.errors.import', compact('errors'));
    }
}
