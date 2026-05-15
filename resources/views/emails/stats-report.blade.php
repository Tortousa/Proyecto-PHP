<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif; color: #333; padding: 24px;">

    <h2>Informe de estadísticas</h2>

    <p>Generado automáticamente el <strong>{{ now()->format('d/m/Y \a \l\a\s H:i') }}</strong>.</p>

    <table style="margin-top: 16px; border-collapse: collapse; width: 100%; max-width: 400px;">
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">Total coches</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $total }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">Publicados</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $published }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">Borradores</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $drafts }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">Precio medio (€)</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($avgPrice, 2, ',', '.') }} €</td>
        </tr>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd; background: #f9f9f9;">Usuarios registrados</td>
            <td style="padding: 8px; border: 1px solid #ddd;">{{ $users }}</td>
        </tr>
    </table>

    <p style="margin-top: 32px; color: #888; font-size: 13px;">
        Este informe se genera automáticamente cada vez que se publica un coche.
    </p>

</body>
</html>
