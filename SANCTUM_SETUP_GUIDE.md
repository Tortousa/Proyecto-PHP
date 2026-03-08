# 🔐 Guía de Prueba: API Authentication con Sanctum

## ✅ Verificación: Sanctum está completamente instalado

Se ha completado la instalación de Laravel Sanctum:

- ✅ Paquete instalado: `laravel/sanctum ^4.3`
- ✅ Configuración publicada: `config/sanctum.php`
- ✅ Migración ejecutada: `personal_access_tokens` tabla creada
- ✅ User Model configurado: Trait `HasApiTokens` agregado
- ✅ Rutas API registradas: 20 endpoints disponibles

---

## 🧪 Prueba Rápida: Obtener Token de Acceso

### Opción 1: cURL (Terminal)

```bash
# 1. Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password"
  }'

# Respuesta esperada:
# {
#   "success": true,
#   "message": "Login successful",
#   "data": {
#     "user": {"id": 1, "name": "...", "email": "..."},
#     "token": "1|abcdefghij..."
#   }
# }

# 2. Guardar el token en una variable
TOKEN="1|abcdefghij..."

# 3. Usar el token para acceder a endpoint protegido
curl -X GET http://localhost:8000/api/car-images \
  -H "Authorization: Bearer $TOKEN"
```

### Opción 2: JavaScript/Postman

**POST** `http://localhost:8000/api/login`

```json
{
  "email": "user@example.com",
  "password": "password"
}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "token": "1|abcdefghij..."
  }
}
```

**Luego usa el token en headers:**
```
Authorization: Bearer 1|abcdefghij...
```

---

## 📱 Prueba con el Cliente JavaScript

Si tienes acceso a la consola del navegador:

```javascript
// En console del navegador (después de abrir tu sitio)
import carApi from './api/carApiClient';

// 1. Login
await carApi.login('user@example.com', 'password');

// 2. Obtener tus imágenes
const images = await carApi.getCarImages();
console.log(images);

// 3. Logout
await carApi.logout();
```

---

## 🔍 Diagnóstico: Verificar Sanctum

### Verificar tabla `personal_access_tokens`

```bash
# Desde tinker
php artisan tinker

# Dentro de tinker:
> App\Models\User::first()->tokens
> DB::table('personal_access_tokens')->get()
```

### Verificar token válido

```bash
php artisan tinker

> $user = App\Models\User::first();
> $token = $user->createToken('api-token')->plainTextToken;
> echo $token;
```

---

## 🚀 Flujo Completo de Prueba

### 1. Asegúrate que tienes un usuario de prueba

```bash
php artisan tinker

> App\Models\User::first()

# Si no existe, crea uno:
> App\Models\User::factory()->create(['email' => 'test@example.com', 'password' => bcrypt('password')])
```

### 2. Login vía API y obtén token

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'
```

### 3. Usa el token en peticiones autenticadas

```bash
# Copiar el token de la respuesta anterior
TOKEN="1|xxxxx..."

# Probar endpoint autenticado
curl -X GET http://localhost:8000/api/car-images \
  -H "Authorization: Bearer $TOKEN"
```

---

## 📋 Endpoints de Prueba

| Endpoint | Método | Autenticación | Descripción |
|----------|--------|---------------|-------------|
| `/api/login` | POST | No | Obtener token |
| `/api/logout` | POST | **Sí** | Revocar token |
| `/api/cars` | GET | No | Listar coches |
| `/api/cars/{id}` | GET | No | Obtener coche |
| `/api/car-images` | GET | **Sí** | Tus imágenes |
| `/api/cars/{car}/images` | GET | **Sí** | Imágenes del coche |
| `/api/cars/{car}/images` | POST | **Sí** | Subir imagen |
| `/api/car-images/{id}` | PUT | **Sí** | Actualizar imagen |
| `/api/car-images/{id}` | DELETE | **Sí** | Borrar imagen |

---

## ❌ Solución de Problemas

### Error: "Unauthorized" (401)

**Causa:** Token no enviado o inválido

**Solución:**
```bash
# ✅ Correcto
curl -H "Authorization: Bearer YOUR_TOKEN" ...

# ❌ Incorrecto
curl -H "Authorization: YOUR_TOKEN" ...  # Falta "Bearer"
curl -H "Authorization: Basic ..." ...    # No usar Basic Auth
```

### Error: "CORS Error"

**Causa:** Origen no permitido

**Solución:** Editar `.env`
```
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1,127.0.0.1:8000
```

### Error: "Not Found" (404)

**Causa:** Endpoint no existe o mal escrito

**Solución:** Verificar rutas
```bash
php artisan route:list --path=/api
```

---

## 💡 Tips

- Los tokens no tienen expiración por defecto (configurable en `config/sanctum.php`)
- Los tokens se almacenan en tabla `personal_access_tokens`
- Solo el propietario puede ver/editar sus imágenes (validado en controladores)
- Las imágenes subidas vía API se guardan en `storage/app/public/cars/`

---

## ✨ Resumen

Sanctum está **100% funcional**. Puedes:

1. ✅ Obtener token vía `/api/login`
2. ✅ Usar token en headers: `Authorization: Bearer TOKEN`
3. ✅ Acceder a endpoints protegidos
4. ✅ Subir, actualizar y borrar imágenes
5. ✅ Logout con `/api/logout`

¡La API está lista para usar! 🚀
