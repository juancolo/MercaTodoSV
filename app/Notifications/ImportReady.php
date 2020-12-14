<?php

namespace App\Notifications;

use App\Entities\ErrorImport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ImportReady extends Notification
{
    use Queueable;

    private $count;
    private $user;

    /**
     * ImportReady constructor.
     * @param $count
     */
    public function __construct($count, $user)
    {
        $this->count = $count;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiab
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting(trans('products.messages.import.greeting', ['user' => $this->user->first_name]))
            ->subject(trans('products.messages.import.subject'))
            ->markdown('email.errors.import',[
                'failures' => ErrorImport::all(),
                'name' => $notifiable->name,
                'count' => $this->count
            ]);
    }
}
