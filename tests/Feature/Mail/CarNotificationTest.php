<?php

// Tests del flujo de notificación cuando un coche queda publicado:
// Evento CarPublished → Listener NotifyCarPublished → Job SendCarPublishedEmailJob → CarPublishedMail.
// También cubre el Mailable del informe de estadísticas (StatsReportMail).

use App\Events\CarPublished;
use App\Jobs\SendCarPublishedEmailJob;
use App\Listeners\NotifyCarPublished;
use App\Mail\CarPublishedMail;
use App\Mail\StatsReportMail;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Mail;

function makeCar(): Car
{
    $maker    = Maker::factory()->create();
    $carModel = CarModel::factory()->create(['maker_id' => $maker->id]);
    $state    = State::factory()->create();
    $city     = City::factory()->create(['state_id' => $state->id]);

    return Car::factory()->create([
        'user_id'      => User::factory()->create()->id,
        'maker_id'     => $maker->id,
        'model_id'     => $carModel->id,
        'car_type_id'  => CarType::factory()->create()->id,
        'fuel_type_id' => FuelType::factory()->create()->id,
        'city_id'      => $city->id,
        'published_at' => now(),
    ]);
}

// ── CarPublishedMail ──────────────────────────────────────────────────────────

test('CarPublishedMail tiene el asunto con marca y modelo y usa su vista', function () {
    $car = makeCar();

    $mail = new CarPublishedMail($car);

    $mail->assertHasSubject('Tu anuncio ya está publicado — ' . $car->maker->name . ' ' . $car->model->name);
    expect($mail->content()->view)->toBe('emails.car-published');
});

// ── StatsReportMail ───────────────────────────────────────────────────────────

test('StatsReportMail expone las estadísticas y usa su vista', function () {
    $mail = new StatsReportMail(total: 10, published: 7, drafts: 3, avgPrice: 15000.5, users: 4);

    expect($mail->total)->toBe(10)
        ->and($mail->published)->toBe(7)
        ->and($mail->drafts)->toBe(3)
        ->and($mail->users)->toBe(4)
        ->and($mail->content()->view)->toBe('emails.stats-report');
    $mail->assertHasSubject('Informe de estadísticas — ' . now()->format('d/m/Y H:i'));
});

// ── SendCarPublishedEmailJob ──────────────────────────────────────────────────

test('el job envía el CarPublishedMail al dueño del coche', function () {
    Mail::fake();
    $car = makeCar();

    (new SendCarPublishedEmailJob($car))->handle();

    Mail::assertSent(CarPublishedMail::class, function ($mail) use ($car) {
        return $mail->hasTo($car->owner->email);
    });
});

// ── NotifyCarPublished (listener) ─────────────────────────────────────────────

test('el listener despacha el job de notificación', function () {
    Bus::fake();
    $car = makeCar();

    (new NotifyCarPublished())->handle(new CarPublished($car));

    Bus::assertDispatched(SendCarPublishedEmailJob::class, function ($job) use ($car) {
        return $job->car->id === $car->id;
    });
});

test('el evento CarPublished dispara el listener registrado', function () {
    Bus::fake();
    $car = makeCar();

    CarPublished::dispatch($car);

    Bus::assertDispatched(SendCarPublishedEmailJob::class);
});
