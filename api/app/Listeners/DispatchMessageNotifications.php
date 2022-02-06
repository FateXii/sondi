<?php

namespace App\Listeners;

use App\Events\NewMessageCreated;
use App\Mail\SiteComunication;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class DispatchMessageNotifications
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
     * @param  NewMessageCreated  $event
     * @return void
     */
    public function handle(NewMessageCreated $event)
    {
        $message = $event->message;

        Mail::to($message->to)->send(new SiteComunication($message));
    }
}
