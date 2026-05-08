<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Jobs\SendWelcomeEmailJob;

// Listener del evento UserRegistered.
// No envía el email directamente — lo delega a un Job para que pueda ejecutarse en cola.
class SendWelcomeMail
{
    public function handle(UserRegistered $event): void
    {
        SendWelcomeEmailJob::dispatch($event->user);
    }
}
