<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; font-size: 13px; }
        h1   { font-size: 20px; color: #4f46e5; margin-bottom: 4px; }
        h2   { font-size: 14px; color: #555; margin-top: 20px; border-bottom: 1px solid #ddd; padding-bottom: 4px; }
        .badge { display: inline-block; background: #e0e7ff; color: #4f46e5; padding: 3px 10px; border-radius: 12px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        td    { padding: 7px 10px; border: 1px solid #e5e7eb; }
        td:first-child { background: #f9fafb; font-weight: bold; width: 40%; }
        .footer { margin-top: 40px; font-size: 11px; color: #aaa; text-align: center; }
    </style>
</head>
<body>

    <h1>{{ $car->maker->name }} {{ $car->model->name }}</h1>
    <span class="badge">{{ $car->year }}</span>

    <h2>Datos del vehículo</h2>
    <table>
        <tr><td>Marca</td><td>{{ $car->maker->name }}</td></tr>
        <tr><td>Modelo</td><td>{{ $car->model->name }}</td></tr>
        <tr><td>Año</td><td>{{ $car->year }}</td></tr>
        <tr><td>Kilómetros</td><td>{{ number_format($car->mileage, 0, ',', '.') }} km</td></tr>
        <tr><td>Combustible</td><td>{{ $car->fuelType->name }}</td></tr>
        <tr><td>Tipo</td><td>{{ $car->carType->name }}</td></tr>
        <tr><td>VIN</td><td>{{ $car->vin }}</td></tr>
    </table>

    <h2>Precio y contacto</h2>
    <table>
        <tr><td>Precio</td><td>{{ number_format($car->price, 0, ',', '.') }} €</td></tr>
        <tr><td>Ciudad</td><td>{{ $car->city->name }}</td></tr>
        <tr><td>Dirección</td><td>{{ $car->address }}</td></tr>
        <tr><td>Teléfono</td><td>{{ $car->phone }}</td></tr>
    </table>

    @if($car->description)
        <h2>Descripción</h2>
        <p>{{ $car->description }}</p>
    @endif

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} — {{ config('app.name') }}
    </div>

</body>
</html>
