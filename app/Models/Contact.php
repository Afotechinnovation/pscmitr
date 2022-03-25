<?php

namespace App\Models;

use App\Notifications\ContactNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\AnonymousNotifiable;

class Contact extends Model
{
    use HasFactory, softDeletes;

    public function send($contact)
    {
        $notification = new ContactNotification($contact);

        $notifiable = new AnonymousNotifiable();

        $to_mail = $contact->email;

        if($to_mail){
            $notifiable->route('mail', $to_mail);
        }

        $notifiable->notify($notification);
    }
}
