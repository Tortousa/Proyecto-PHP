<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

// Job síncrono: se ejecuta inmediatamente en la misma petición HTTP (sin cola).
// Contrasta con SendCarPublishedEmailJob, que implementa ShouldQueue y se delega al worker.
class SendWelcomeEmailJob
{
    use Dispatchable;

    public function __construct(public User $user) {}

    public function handle(): void
    {
        Mail::to($this->user)->send(new WelcomeMail($this->user));
    }
}
