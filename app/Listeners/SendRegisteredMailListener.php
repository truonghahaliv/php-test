<?php

namespace App\Listeners;

use App\Events\RegisteredEvent;
use App\Mail\SendMailVerification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegisteredMailListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisteredEvent $event): void
    {
        //

      Mail::to($event->user->email)->send(new SendMailVerification($event->user));


    }
}
