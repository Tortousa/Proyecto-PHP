<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif; color: #333; padding: 24px;">

    <h2>Tu anuncio ya está publicado</h2>

    <p>Hola <strong>{{ $car->owner->name }}</strong>,</p>

    <p>Tu coche <strong>{{ $car->maker->name }} {{ $car->model->name }} ({{ $car->year }})</strong>
    ya está visible para todos los usuarios.</p>

    <table style="margin-top: 16px; border-collapse: collapse; width: 100%; max-width: 400px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">Precio</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($car->price, 0, ',', '.') }} €</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">Kilómetros</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($car->mileage, 0, ',', '.') }} km</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">Ciudad</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $car->city->name }}</td>
        </tr>
    </table>

    <p style="margin-top: 32px; color: #888; font-size: 13px;">
        Recibes este email porque eres el propietario del anuncio.
    </p>

</body>
</html>
