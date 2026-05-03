<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// Este Mailable define el email de bienvenida que recibe un usuario al registrarse.
// Aquí configuramos el asunto y la vista que se usará para el cuerpo del email.
class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Bienvenido a ' . config('app.name') . '!',
        );
    }

    public function content(): Content
    {
        // La vista que usaremos para el cuerpo del email
        return new Content(
            view: 'emails.welcome',
        );
    }
}
