<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

// Mailable que envía el informe diario de estadísticas al administrador.
// Lo despacha el comando app:cars-stats, programado cada mañana via Schedule.
class StatsReportMail extends Mailable
{
    public function __construct(
        public int $total,
        public int $published,
        public int $drafts,
        public float $avgPrice,
        public int $users,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Informe de estadísticas — ' . now()->format('d/m/Y H:i'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.stats-report',
        );
    }
}
