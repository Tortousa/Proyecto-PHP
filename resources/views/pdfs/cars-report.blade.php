<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body  { font-family: DejaVu Sans, sans-serif; color: #333; font-size: 12px; }
        h1    { font-size: 22px; color: #4f46e5; margin-bottom: 2px; }
        h2    { font-size: 14px; color: #4f46e5; margin-top: 24px; border-bottom: 2px solid #4f46e5; padding-bottom: 4px; }
        .subtitle { color: #888; font-size: 12px; margin-bottom: 20px; }

        /* Tarjetas de estadísticas */
        .stats { width: 100%; margin-bottom: 20px; }
        .stats td { width: 25%; text-align: center; background: #f0f4ff; border: 1px solid #c7d2fe; padding: 12px; }
        .stats .num  { font-size: 22px; font-weight: bold; color: #4f46e5; }
        .stats .label { font-size: 10px; color: #666; margin-top: 2px; }

        /* Tabla de coches */
        .cars-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .cars-table th { background: #4f46e5; color: white; padding: 8px; text-align: left; font-size: 11px; }
        .cars-table td { padding: 7px 8px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        .cars-table tr:nth-child(even) td { background: #f9fafb; }

        /* Tabla de marcas más vendidas */
        .makers-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        .makers-table th { background: #6366f1; color: white; padding: 7px; font-size: 11px; }
        .makers-table td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; font-size: 11px; text-align: center; }

        .footer { margin-top: 40px; font-size: 10px; color: #aaa; text-align: center; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <h1>Informe de anuncios</h1>
    <p class="subtitle">Generado el {{ now()->format('d/m/Y H:i') }}</p>

    {{-- Estadísticas generales --}}
    <h2>Resumen general</h2>
    <table class="stats">
        <tr>
            <td>
                <div class="num">{{ $totalCoches }}</div>
                <div class="label">Anuncios publicados</div>
            </td>
            <td>
                <div class="num">{{ number_format($precioMedio, 0, ',', '.') }} €</div>
                <div class="label">Precio medio</div>
            </td>
            <td>
                <div class="num">{{ number_format($precioMin, 0, ',', '.') }} €</div>
                <div class="label">Precio mínimo</div>
            </td>
            <td>
                <div class="num">{{ number_format($precioMax, 0, ',', '.') }} €</div>
                <div class="label">Precio máximo</div>
            </td>
        </tr>
    </table>

    {{-- Marcas más publicadas --}}
    <h2>Marcas más publicadas</h2>
    <table class="makers-table">
        <thead>
            <tr>
                <th>Marca</th>
                <th>Anuncios</th>
                <th>Precio medio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($porMarca as $fila)
            <tr>
                <td>{{ $fila->maker }}</td>
                <td>{{ $fila->total }}</td>
                <td>{{ number_format($fila->precio_medio, 0, ',', '.') }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Listado completo --}}
    <h2>Listado de anuncios</h2>
    <table class="cars-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Vehículo</th>
                <th>Año</th>
                <th>Km</th>
                <th>Combustible</th>
                <th>Ciudad</th>
                <th>Precio</th>
                <th>Vendedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cars as $i => $car)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $car->maker->name }} {{ $car->model->name }}</td>
                <td>{{ $car->year }}</td>
                <td>{{ number_format($car->mileage, 0, ',', '.') }}</td>
                <td>{{ $car->fuelType->name }}</td>
                <td>{{ $car->city->name }}</td>
                <td>{{ number_format($car->price, 0, ',', '.') }} €</td>
                <td>{{ $car->owner->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ config('app.name') }} — Informe generado automáticamente
    </div>

</body>
</html>
