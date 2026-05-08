<?php

namespace App\Jobs;

use App\Mail\CarPublishedMail;
use App\Models\Car;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

// Job que notifica al vendedor cuando su anuncio queda publicado.
// También usa ShouldQueue para ejecutarse en cola y no bloquear la petición HTTP.
class SendCarPublishedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Car $car) {}

    public function handle(): void
    {
        Mail::to($this->car->owner)->send(new CarPublishedMail($this->car));
    }
}
