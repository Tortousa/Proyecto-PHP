<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        @page   { margin: 0; }
        body    { font-family: DejaVu Sans, sans-serif; color: #333; font-size: 13px; margin: 0; padding: 0; width: 100%; }
        .header { background: #1f2937; padding: 14px 20px 14px 20px; margin: 0 0 24px 0; width: 100%; }
        .header table { width: 100%; border-collapse: collapse; margin: 0; }
        .header table td { border: none; background: transparent; padding: 0; vertical-align: middle; }
        .header-logo img { width: 44px; height: auto; }
        .header-text { padding-left: 12px; }
        .header-text .brand { font-size: 18px; font-weight: bold; color: #facc15; }
        .header-text .tagline { font-size: 10px; color: #9ca3af; margin-top: 2px; }
        .content { padding: 24px 20px; }
        h1   { font-size: 20px; color: #1f2937; margin-bottom: 4px; }
        h2          { font-size: 14px; color: #555; margin-top: 20px; border-bottom: 1px solid #ddd; padding-bottom: 4px; page-break-after: avoid; }
        .h2-desc    { margin-top: 40px; }
        .badge { display: inline-block; background: #fef9c3; color: #854d0e; padding: 3px 10px; border-radius: 12px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        td    { padding: 7px 10px; border: 1px solid #e5e7eb; }
        td:first-child { background: #f9fafb; font-weight: bold; width: 40%; }
        .footer { margin-top: 40px; font-size: 11px; color: #aaa; text-align: center; border-top: 1px solid #e5e7eb; padding-top: 12px; }
        .car-img { width: 60%; height: auto; border-radius: 6px; margin-bottom: 16px; display: block; }
    </style>
</head>
<body>

    {{-- Cabecera membrete --}}
    <div class="header">
        <table>
            <tr>
                <td class="header-logo" style="width:52px;">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" alt="Logo">
                    @endif
                </td>
                <td class="header-text">
                    <div class="brand">Segunda Marcha</div>
                    <div class="tagline">Compra y vende tu coche</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">

    @if($imagenBase64)
        <img src="{{ $imagenBase64 }}" class="car-img" alt="Foto del vehículo">
    @endif

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
        <h2 class="h2-desc">Descripción</h2>
        <p>{{ $car->description }}</p>
    @endif

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} — {{ config('app.name') }}
    </div>

    </div>{{-- .content --}}

</body>
</html>
