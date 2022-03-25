<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DoubtNotification extends Notification
{
    use Queueable;
    public $doubt;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($doubt)
    {
        $this->doubt = $doubt;
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
        info($this->doubt);
        return (new MailMessage)
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject(__('Doubt Answering Messages'))
            ->line(__())
            ->line('Thank you for being a part of '.env('APP_NAME').'. We are happy to help you with this doubt.')
            ->line('Question : '. strip_tags(html_entity_decode($this->doubt->question->question)))
            ->line('Answer : '.$this->doubt->answer)
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
