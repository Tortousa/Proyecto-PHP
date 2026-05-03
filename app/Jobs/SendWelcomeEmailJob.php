<?php

namespace App\Jobs;

use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

// Este job envía el email de bienvenida al usuario recién registrado.
// Al implementar ShouldQueue, Laravel lo procesa en segundo plano usando la cola.
class SendWelcomeEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private User $user) {}

    public function handle(): void
    {
        // Enviamos el email de bienvenida usando el Mailable WelcomeMail
        Mail::to($this->user->email)->send(new WelcomeMail($this->user));
    }
}
