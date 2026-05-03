<?php

namespace App\Mail;

use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// Este Mailable define el email que se envía al dueño cuando su coche queda publicado.
// Recibe el coche para poder mostrar sus detalles en el cuerpo del email.
class CarPublishedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Car $car) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu anuncio ya está publicado — ' . $this->car->maker->name . ' ' . $this->car->model->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.car-published',
        );
    }
}
