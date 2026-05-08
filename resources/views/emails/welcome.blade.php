<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: sans-serif; color: #333; padding: 24px;">

    <h2>¡Bienvenido, {{ $user->name }}!</h2>

    <p>Tu cuenta en <strong>{{ config('app.name') }}</strong> ha sido creada correctamente.</p>

    <p>Ya puedes publicar tus coches y guardar tus favoritos.</p>

    <p style="margin-top: 32px; color: #888; font-size: 13px;">
        Si no has sido tú quien se ha registrado, ignora este mensaje.
    </p>

</body>
</html>
