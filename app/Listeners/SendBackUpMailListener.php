<?php

namespace App\Listeners;

use App\Mail\BackupMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Spatie\Backup\Events\BackupZipWasCreated;

class SendBackUpMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BackupZipWasCreated $event)
    {

        try {

            $backUpMailAttributes['path_to_zip'] = $event->pathToZip;

            $backUpMailAttributes['email'] = env('BACKUP_MAIL_TO_ADDRESS');

            Mail::send(new BackUpMail($backUpMailAttributes));

        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }
}
