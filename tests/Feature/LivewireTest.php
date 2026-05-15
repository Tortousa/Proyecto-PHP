<?php

// Tests de los componentes Livewire.
// Usan Livewire::test() para ejercitar los métodos sin montar una sesión de navegador.

use App\Livewire\AdminUsers;
use App\Livewire\CarImages;
use App\Livewire\CarSearch;
use App\Livewire\FavouriteButton;
use App\Livewire\FavouritesList;
use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    Event::fake();

    $maker      = Maker::factory()->create();
    $carModel   = \App\Models\CarModel::factory()->create(['maker_id' => $maker->id]);
    $carType    = CarType::factory()->create();
    $fuelType   = FuelType::factory()->create();
    $state      = State::factory()->create();
    $city       = City::factory()->create(['state_id' => $state->id]);

    $this->user  = User::factory()->create(['rol' => 'user']);
    $this->admin = User::factory()->create(['rol' => 'admin']);

    $this->car = Car::factory()->create([
        'user_id'      => $this->user->id,
        'maker_id'     => $maker->id,
        'model_id'     => $carModel->id,
        'car_type_id'  => $carType->id,
        'fuel_type_id' => $fuelType->id,
        'city_id'      => $city->id,
        'published_at' => now(),
    ]);

    $this->ref = compact('maker', 'carModel', 'carType', 'fuelType', 'city');
});

// ── AdminUsers ────────────────────────────────────────────────────────────────

test('AdminUsers renderiza la lista de usuarios', function () {
    Livewire::actingAs($this->admin)
        ->test(AdminUsers::class)
        ->assertOk();
});

test('AdminUsers filtra usuarios por nombre al buscar', function () {
    Livewire::actingAs($this->admin)
        ->test(AdminUsers::class)
        ->set('search', $this->user->name)
        ->assertSee($this->user->name);
});

test('AdminUsers carga los datos del usuario al editar', function () {
    Livewire::actingAs($this->admin)
        ->test(AdminUsers::class)
        ->call('edit', $this->user->id)
        ->assertSet('editingId', $this->user->id)
        ->assertSet('editName', $this->user->name);
});

test('AdminUsers guarda los cambios del usuario', function () {
    Livewire::actingAs($this->admin)
        ->test(AdminUsers::class)
        ->call('edit', $this->user->id)
        ->set('editName', 'Nombre Cambiado')
        ->set('editEmail', $this->user->email)
        ->set('editRol', 'user')
        ->call('save')
        ->assertSet('editingId', null);

    expect($this->user->fresh()->name)->toBe('Nombre Cambiado');
});

test('AdminUsers cancela la edición limpiando el estado', function () {
    Livewire::actingAs($this->admin)
        ->test(AdminUsers::class)
        ->call('edit', $this->user->id)
        ->call('cancel')
        ->assertSet('editingId', null);
});

test('AdminUsers elimina un usuario', function () {
    $userToDelete = User::factory()->create();

    Livewire::actingAs($this->admin)
        ->test(AdminUsers::class)
        ->call('delete', $userToDelete->id);

    expect(User::find($userToDelete->id))->toBeNull();
});

// ── CarSearch ─────────────────────────────────────────────────────────────────

test('CarSearch renderiza los coches publicados', function () {
    Livewire::actingAs($this->user)
        ->test(CarSearch::class)
        ->assertOk();
});

test('CarSearch filtra coches por texto de búsqueda', function () {
    Livewire::actingAs($this->user)
        ->test(CarSearch::class)
        ->set('search', 'MarcaInexistente123')
        ->assertOk();
});

test('CarSearch filtra coches por tipo de combustible', function () {
    Livewire::actingAs($this->user)
        ->test(CarSearch::class)
        ->set('fuelType', (string) $this->ref['fuelType']->id)
        ->assertOk();
});

test('CarSearch ordena coches por precio ascendente', function () {
    Livewire::actingAs($this->user)
        ->test(CarSearch::class)
        ->set('sortBy', 'price_asc')
        ->assertOk();
});

test('CarSearch ordena coches por precio descendente', function () {
    Livewire::actingAs($this->user)
        ->test(CarSearch::class)
        ->set('sortBy', 'price_desc')
        ->assertOk();
});

test('CarSearch añade un coche a favoritos si el usuario está autenticado', function () {
    Livewire::actingAs($this->user)
        ->test(CarSearch::class)
        ->call('toggleFavourite', $this->car->id)
        ->assertOk();

    expect($this->user->favouriteCars()->where('car_id', $this->car->id)->exists())->toBeTrue();
});

test('CarSearch quita un coche de favoritos si ya era favorito', function () {
    $this->user->favouriteCars()->attach($this->car->id, ['notes' => null, 'added_at' => now()]);

    Livewire::actingAs($this->user)
        ->test(CarSearch::class)
        ->call('toggleFavourite', $this->car->id)
        ->assertOk();

    expect($this->user->favouriteCars()->where('car_id', $this->car->id)->exists())->toBeFalse();
});

// ── FavouriteButton ───────────────────────────────────────────────────────────

test('FavouriteButton renderiza el botón para un coche no favorito', function () {
    Livewire::actingAs($this->user)
        ->test(FavouriteButton::class, ['carId' => $this->car->id])
        ->assertSet('isFavourite', false)
        ->assertOk();
});

test('FavouriteButton marca el coche como favorito al hacer toggle', function () {
    Livewire::actingAs($this->user)
        ->test(FavouriteButton::class, ['carId' => $this->car->id])
        ->call('toggle')
        ->assertSet('isFavourite', true);

    expect($this->user->favouriteCars()->where('car_id', $this->car->id)->exists())->toBeTrue();
});

test('FavouriteButton quita el favorito al hacer toggle por segunda vez', function () {
    $this->user->favouriteCars()->attach($this->car->id, ['notes' => null, 'added_at' => now()]);

    Livewire::actingAs($this->user)
        ->test(FavouriteButton::class, ['carId' => $this->car->id])
        ->assertSet('isFavourite', true)
        ->call('toggle')
        ->assertSet('isFavourite', false);
});

// ── FavouritesList ────────────────────────────────────────────────────────────

test('FavouritesList renderiza la lista de favoritos del usuario', function () {
    $this->user->favouriteCars()->attach($this->car->id, ['notes' => 'Mi nota', 'added_at' => now()]);

    Livewire::actingAs($this->user)
        ->test(FavouritesList::class)
        ->assertOk();
});

test('FavouritesList abre la edición de nota de un favorito', function () {
    $this->user->favouriteCars()->attach($this->car->id, ['notes' => 'Nota original', 'added_at' => now()]);

    Livewire::actingAs($this->user)
        ->test(FavouritesList::class)
        ->call('startEdit', $this->car->id)
        ->assertSet('editingId', $this->car->id)
        ->assertSet('editingNote', 'Nota original');
});

test('FavouritesList cancela la edición limpiando el estado', function () {
    $this->user->favouriteCars()->attach($this->car->id, ['notes' => null, 'added_at' => now()]);

    Livewire::actingAs($this->user)
        ->test(FavouritesList::class)
        ->call('startEdit', $this->car->id)
        ->call('cancelEdit')
        ->assertSet('editingId', null);
});

test('FavouritesList guarda la nota en la tabla pivote', function () {
    $this->user->favouriteCars()->attach($this->car->id, ['notes' => null, 'added_at' => now()]);

    Livewire::actingAs($this->user)
        ->test(FavouritesList::class)
        ->call('startEdit', $this->car->id)
        ->set('editingNote', 'Nueva nota')
        ->call('saveNote')
        ->assertSet('editingId', null);

    $pivot = $this->user->favouriteCars()->where('car_id', $this->car->id)->first()->pivot;
    expect($pivot->notes)->toBe('Nueva nota');
});

test('FavouritesList elimina un coche de favoritos', function () {
    $this->user->favouriteCars()->attach($this->car->id, ['notes' => null, 'added_at' => now()]);

    Livewire::actingAs($this->user)
        ->test(FavouritesList::class)
        ->call('remove', $this->car->id);

    expect($this->user->favouriteCars()->where('car_id', $this->car->id)->exists())->toBeFalse();
});

test('FavouritesList refresca al recibir el evento favouriteToggled', function () {
    Livewire::actingAs($this->user)
        ->test(FavouritesList::class)
        ->dispatch('favouriteToggled')
        ->assertOk();
});

// ── FavouriteButton sin autenticación ────────────────────────────────────────

test('FavouriteButton redirige al login si el usuario no está autenticado', function () {
    Livewire::test(FavouriteButton::class, ['carId' => $this->car->id])
        ->call('toggle')
        ->assertRedirect(route('login'));
});

// ── CarSearch sin autenticación ───────────────────────────────────────────────

test('CarSearch redirige al login al hacer toggle sin autenticación', function () {
    Livewire::test(CarSearch::class)
        ->call('toggleFavourite', $this->car->id)
        ->assertRedirect(route('login'));
});

// ── CarImages ────────────────────────────────────────────────────────────────

test('CarImages renderiza las imágenes del coche', function () {
    Livewire::actingAs($this->user)
        ->test(CarImages::class, ['car' => $this->car])
        ->assertOk();
});

test('CarImages sube una imagen y la asocia al coche', function () {
    Storage::fake('public');
    $before = $this->car->images()->count();
    $file   = UploadedFile::fake()->image('test.jpg');

    Livewire::actingAs($this->user)
        ->test(CarImages::class, ['car' => $this->car])
        ->set('newImage', $file)
        ->call('upload');

    expect($this->car->images()->count())->toBe($before + 1);
});

test('CarImages elimina una imagen del coche', function () {
    Storage::fake('public');
    $path = UploadedFile::fake()->image('test.jpg')->store('cars', 'public');

    $image  = $this->car->images()->create(['image_path' => $path, 'position' => 1]);
    $before = $this->car->images()->count();

    Livewire::actingAs($this->user)
        ->test(CarImages::class, ['car' => $this->car])
        ->call('delete', $image->id);

    expect($this->car->images()->count())->toBe($before - 1);
});
