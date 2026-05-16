# Despliegue en Render

**Tiempo estimado total: ~1h 15min** (incluyendo espera de builds)

---

## Requisitos previos

- Cuenta en [render.com](https://render.com) (gratuita)
- Repositorio en GitHub con el código subido
- El `render.yaml`, `Dockerfile` y `docker-entrypoint.sh` ya están en el repo

> **Nota sobre imágenes subidas:** Render usa un sistema de ficheros efímero.
> Las imágenes que los usuarios suban se perderán al reiniciar el servicio.
> Para un entorno de demo/evaluación esto es aceptable. Para producción real
> habría que conectar un bucket S3 o Cloudinary.

---

## Paso 1 — Subir el código a GitHub (~5 min)

Si aún no tienes el repo en GitHub, desde la raíz del proyecto:

```bash
git add Dockerfile docker-entrypoint.sh .dockerignore render.yaml
git commit -m "chore: add Render deployment config"
git push
```

---

## Paso 2 — Crear la base de datos PostgreSQL en Render (~5 min)

1. Entra en [dashboard.render.com](https://dashboard.render.com)
2. Clic en **New → PostgreSQL**
3. Configura:
   - **Name:** `proyecto-php-db`
   - **Database:** `proyecto_php`
   - **Plan:** Free
4. Clic en **Create Database**
5. Espera ~1 min hasta que el estado sea **Available**

---

## Paso 3 — Crear el Web Service (~5 min)

1. Clic en **New → Web Service**
2. Conecta tu repositorio de GitHub
3. Render detectará el `render.yaml` automáticamente y rellenará la config
4. Verifica que aparece:
   - **Runtime:** Docker
   - **Port:** 80
5. Clic en **Create Web Service**

---

## Paso 4 — Ajustar la APP_URL (~2 min)

Una vez creado el servicio, Render te asigna una URL del tipo:
```
https://proyecto-php-xxxx.onrender.com
```

1. Ve a tu Web Service → **Environment**
2. Edita la variable `APP_URL` y pon la URL real que te ha asignado Render
3. Clic en **Save Changes** (esto disparará un nuevo deploy automáticamente)

---

## Paso 5 — Esperar el primer build (~15-20 min)

El primer build tarda más porque:
- Descarga la imagen base de PHP + Apache
- Instala dependencias de Composer y npm
- Compila los assets con Vite

Puedes ver el progreso en la pestaña **Logs** del servicio.

Si el deploy termina en verde (`Live`) pasa al paso 6.

---

## Paso 6 — Poblar la base de datos con el seeder (~3 min)

Una vez el servicio esté en verde, abre la terminal integrada de Render:

1. Ve a tu Web Service → **Shell**
2. Ejecuta:

```bash
php artisan db:seed --force
```

Esto crea los datos iniciales (tipos de coche, combustible, ciudades, etc.).

---

## Paso 7 — Verificar que todo funciona (~5 min)

Abre la URL del servicio y comprueba:

- [ ] La home carga con el catálogo de coches
- [ ] El registro e inicio de sesión funcionan
- [ ] Se puede publicar un coche
- [ ] La API responde en `/api/cars`
- [ ] El PDF se genera en el detalle de un coche

---

## Variables de entorno importantes

| Variable | Valor en producción | Por qué |
|---|---|---|
| `APP_ENV` | `production` | Desactiva mensajes de debug |
| `APP_DEBUG` | `false` | No expone stack traces |
| `APP_KEY` | (generada por Render) | Encripta sesiones y cookies |
| `DB_CONNECTION` | `pgsql` | PostgreSQL en lugar de MySQL |
| `SESSION_DRIVER` | `database` | Sesiones persistentes en BD |
| `SESSION_SECURE_COOKIE` | `true` | Solo cookies por HTTPS |
| `LOG_CHANNEL` | `stderr` | Los logs van a la consola de Render |

---

## Añadir tu propio dominio (opcional, ~10 min)

1. Web Service → **Settings → Custom Domains**
2. Añade tu dominio (ej: `proyecto.tu-dominio.com`)
3. Render te da los registros DNS a configurar en tu proveedor
4. El certificado SSL se genera automáticamente
5. Actualiza `APP_URL` con el nuevo dominio

---

## Solución de problemas frecuentes

**El build falla en `npm run build`**
→ Comprueba que `package.json` y `vite.config.js` están en el repo (no en `.gitignore`)

**Error 500 al abrir la web**
→ Ve a Logs y busca el error real. Casi siempre es `APP_KEY` vacía o una variable de BD mal configurada.

**Las migraciones fallan**
→ Verifica que la BD PostgreSQL está en estado `Available` antes de que el web service arranque.

**Imágenes de coches rotas después de reiniciar**
→ Es el comportamiento esperado en el plan gratuito (filesystem efímero). Las imágenes externas (URLs) sí persisten.
