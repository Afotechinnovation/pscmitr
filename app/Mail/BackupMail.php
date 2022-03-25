<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BackupMail extends Mailable
{
    use Queueable, SerializesModels;


    var $attributes;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // $this->attributes['logo'] = env('URL') . '/assets/admin/images/logo1.png';

       // info($this->attributes['path_to_zip']);
        return $this->to($this->attributes['email'])
            ->subject('PSCMITR - BACKUP MAIL')
            ->view('admin::pages.emails.back_up_mail')
            ->with('attributes', $this->attributes)
            ->attach( $this->attributes['path_to_zip']);
    }
}
