<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoleNotification extends Notification
{
    use Queueable;
    public $admin;
    private $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($admin, $password)
    {
        $this->admin = $admin;
        $this->password = $password;
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
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from( env('MAIL_FROM_ADDRESS') )
            ->subject(__('Welcome'))
            ->line(__())
            ->line('Thank you for being a part of ' . env('APP_NAME') . '. Your account credentials are given below. Do not share with others.')
            ->line('Name : ' . $this->admin->name)
            ->line('Email : ' . $this->admin->email)
            ->line('Password : ' . $this->password)
            ->line(__());
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
