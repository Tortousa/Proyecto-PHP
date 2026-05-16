# Despliegue en Render — Proyecto PHP Laravel

## Requisitos previos

- Repositorio en GitHub (público o privado con acceso)
- Cuenta en [render.com](https://render.com)
- Proyecto Laravel con `Dockerfile`, `render.yaml` y `docker-entrypoint.sh`

---

## Archivos de configuración necesarios

### `Dockerfile`
Imagen `php:8.2-apache` con:
- Módulos Apache: `rewrite`, `headers`
- Extensiones PHP: `pdo`, `pdo_pgsql`, `mbstring`, `zip`, `exif`, `pcntl`, `bcmath`, `gd`, `opcache`
- Node.js 20 para compilar assets con Vite
- Composer 2
- DocumentRoot apuntando a `public/`
- `AllowOverride All` en el directorio `public/`
- Script de entrypoint que ejecuta migraciones y caché al arrancar

### `docker-entrypoint.sh`
```bash
#!/bin/bash
set -e
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force --no-interaction
php artisan storage:link --force
exec "$@"
```

### `render.yaml`
Define el servicio web (Docker, puerto 80) y la base de datos PostgreSQL.  
Variables de entorno clave:
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_KEY` con `generateValue: true`
- `APP_URL` con la URL real del servicio en Render
- `DB_CONNECTION=pgsql`
- Credenciales de BD enlazadas con `fromDatabase`
- `SESSION_DRIVER=database`
- `CACHE_STORE=database`
- `LOG_CHANNEL=stderr`

---

## Pasos realizados

### 1. Crear el servicio en Render
- Ir a [render.com](https://render.com) → **New → Web Service**
- Conectar el repositorio de GitHub
- Seleccionar runtime **Docker**
- Render detecta el `Dockerfile` automáticamente

### 2. Crear la base de datos PostgreSQL
- En Render → **New → PostgreSQL**
- Plan Free
- Render genera automáticamente nombre de BD, usuario y contraseña

### 3. Corregir `APP_URL` en `render.yaml`
Render asigna un subdominio aleatorio (ej. `proyecto-php-suk0.onrender.com`).  
Actualizar `render.yaml`:
```yaml
- key: APP_URL
  value: https://proyecto-php-suk0.onrender.com
```

### 4. Configurar credenciales de BD manualmente
Si el `fromDatabase` no enlaza correctamente las credenciales:
1. Ir a la BD en Render → revelar **Internal Database URL** o la contraseña
2. Ir al Web Service → pestaña **Environment**
3. Establecer manualmente:
   - `DB_HOST` → hostname interno de la BD (ej. `dpg-xxxxx-a`)
   - `DB_PORT` → `5432`
   - `DB_DATABASE` → nombre real generado por Render
   - `DB_USERNAME` → usuario real generado por Render
   - `DB_PASSWORD` → contraseña revelada desde el dashboard

### 5. Corregir migraciones MySQL-only para PostgreSQL
Las migraciones escritas para MySQL con `SHOW INDEX FROM` fallan en PostgreSQL.  
Reemplazar por `Schema::hasIndex()` que es compatible con ambos motores:

```php
// ❌ MySQL only
DB::select("SHOW INDEX FROM `{$table}`")

// ✅ Compatible MySQL + PostgreSQL
Schema::hasIndex($table, $indexName)
```

### 6. Configurar TrustProxies para HTTPS
Render actúa como proxy inverso: termina HTTPS y reenvía HTTP al contenedor.  
Sin configurar los proxies de confianza, Laravel genera URLs `http://` y los assets no cargan.

En `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->trustProxies(at: '*');
    // ... resto de middleware
})
```

---

### 7. Mover `fakerphp/faker` a dependencias de producción
El Dockerfile instala con `--no-dev`, así que `faker` (en `require-dev` por defecto) no estará disponible para el seeder.

En `composer.json`, mover de `require-dev` a `require`:
```json
"require": {
    "fakerphp/faker": "^1.23",
    ...
}
```
Ejecutar `composer update fakerphp/faker` para actualizar el `composer.lock`.

### 8. Usar `migrate:fresh --seed` en el entrypoint
Para evitar datos parciales de deploys fallidos, el entrypoint recrea la BD limpia en cada deploy:

```bash
php artisan migrate:fresh --seed --force --no-interaction
```

### 9. Reemplazar `fake()` por `$this->faker` en factories
`fake()` puede no estar disponible en producción sin dev dependencies. Usar `$this->faker` en todas las factories.

---

## Errores encontrados y soluciones

| Error | Causa | Solución |
|---|---|---|
| `password authentication failed for user` | Render genera usuario/BD con nombre aleatorio, distinto al del `render.yaml` | Poner credenciales reales manualmente en Environment |
| `SHOW INDEX FROM syntax error` | Sintaxis MySQL no soportada en PostgreSQL | Usar `Schema::hasIndex()` |
| Assets CSS/JS con URL `http://` en vez de `https://` | Render hace proxy HTTPS→HTTP, Laravel no detecta HTTPS | `$middleware->trustProxies(at: '*')` en `bootstrap/app.php` |
| `Call to undefined function fake()` | `fakerphp/faker` era `require-dev`, no disponible con `--no-dev` | Moverlo a `require` en `composer.json` |
| `Attempt to read property "id" on null` en CarFactory | BD con datos parciales de deploys fallidos, CarModels no existían | Usar `migrate:fresh --seed` para BD siempre limpia |
| Botón de idioma no visible en home | Navbar transparente + texto gris invisible sobre fondo claro | Colores dinámicos con Alpine.js según scroll |
| Botón de idioma no visible en móvil | `hidden sm:flex` lo ocultaba en pantallas pequeñas | Añadir switcher al menú hamburguesa |

---

## Notas

- El plan **Free** de Render apaga el servicio tras 15 min de inactividad. El primer acceso puede tardar ~30 segundos en arrancar.
- La base de datos Free **expira a los 90 días**.
- Con `migrate:fresh --seed` los datos se borran en cada redeploy — apto para demo, no para producción real.
- Las imágenes subidas por usuarios se perderán en cada redeploy (almacenamiento efímero). Para producción real usar S3 o Cloudinary.
