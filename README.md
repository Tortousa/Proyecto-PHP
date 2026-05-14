<div align="center">

# 🚗 Segunda Marcha

### Marketplace de coches de segunda mano — Laravel 12 fullstack

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Livewire](https://img.shields.io/badge/Livewire-4.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Tests](https://img.shields.io/badge/Coverage-85.58%25-22C55E?style=for-the-badge&logo=testcafe&logoColor=white)](./phpunit.xml)
[![License](https://img.shields.io/badge/License-MIT-blue?style=for-the-badge)](LICENSE)

*Plataforma completa para comprar y vender vehículos de segunda mano.*  
*Autenticación dual (web + API), componentes reactivos con Livewire y documentación OpenAPI.*

</div>

---

## Tabla de contenidos

- [Características](#-características)
- [Stack tecnológico](#-stack-tecnológico)
- [Arquitectura](#-arquitectura)
- [Instalación](#-instalación)
- [Variables de entorno](#-variables-de-entorno)
- [Base de datos](#-base-de-datos)
- [API REST](#-api-rest)
- [Componentes Livewire](#-componentes-livewire)
- [Comandos Artisan](#-comandos-artisan)
- [Tests](#-tests)
- [Despliegue](#-despliegue)

---

## ✨ Características

| Módulo | Descripción |
|--------|-------------|
| **Autenticación Web** | Registro, login, verificación de email y recuperación de contraseña con Laravel Breeze |
| **API REST con Sanctum** | 15+ endpoints protegidos con Bearer tokens, documentados en Swagger/OpenAPI |
| **Buscador en tiempo real** | Filtrado de anuncios sin recargar página mediante Livewire |
| **Favoritos** | Toggles instantáneos con notas personalizadas por vehículo |
| **Panel de administración** | Gestión de usuarios y coches con control de roles (user / admin) |
| **Subida de imágenes** | Carga múltiple, reordenación por posición y previsualización |
| **Generación de PDFs** | Ficha de vehículo y reporte global descargables con DomPDF |
| **Eventos y colas** | Emails asíncronos al registrarse y al publicar un anuncio |
| **Multiidioma** | Interfaz en español e inglés con selector dinámico |
| **Cobertura de tests** | 85.58 % de líneas cubiertas con Pest (102+ tests) |

---

## 🛠 Stack tecnológico

### Backend

| Tecnología | Versión | Uso |
|-----------|---------|-----|
| [Laravel](https://laravel.com) | ^12.0 | Framework principal |
| [PHP](https://php.net) | ^8.2 | Lenguaje |
| [Laravel Sanctum](https://laravel.com/docs/sanctum) | ^4.3 | Autenticación API |
| [Livewire](https://livewire.laravel.com) | ^4.3 | Componentes reactivos |
| [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger) | ^11.0 | Documentación OpenAPI |
| [DomPDF](https://github.com/barryvdh/laravel-dompdf) | ^3.1 | Generación de PDFs |
| [Laravel Breeze](https://laravel.com/docs/starter-kits) | ^2.3 | Scaffolding de auth |
| MySQL | 8+ | Base de datos principal |

### Frontend

| Tecnología | Versión | Uso |
|-----------|---------|-----|
| [Vite](https://vitejs.dev) | ^7.0 | Bundler |
| [Tailwind CSS](https://tailwindcss.com) | ^3.1 | Estilos |
| [Alpine.js](https://alpinejs.dev) | ^3.4 | Interactividad ligera |
| [Axios](https://axios-http.com) | ^1.11 | HTTP cliente |

### Testing

| Tecnología | Versión | Uso |
|-----------|---------|-----|
| [Pest](https://pestphp.com) | ^3.8 | Framework de tests |
| [Mockery](https://mockery.github.io) | — | Mocking |
| MySQL `laravel_coches_test` | — | Base de datos de test aislada |

---

## 🏗 Arquitectura

```
app/
├── Console/Commands/          # Artisan: publish-cars, clean-drafts, cars-stats
├── Events/                    # UserRegistered, CarPublished
├── Http/
│   ├── Controllers/
│   │   ├── Api/               # AuthController, CarController, FavouriteController...
│   │   └── Web/               # HomeController, CarController, AdminUserController...
│   ├── Livewire/              # CarSearch, CarImages, FavouriteButton, AdminUsers...
│   ├── Middleware/            # RoleMiddleware, SetLocale
│   ├── Requests/              # StoreCarRequest, RegisterRequest...
│   └── Resources/             # CarResource, UserResource, CarSummaryResource...
├── Jobs/                      # SendWelcomeEmailJob, SendCarPublishedEmailJob
├── Listeners/                 # SendWelcomeMail, NotifyCarPublished
├── Mail/                      # WelcomeMail, CarPublishedMail
├── Models/                    # Car, User, Maker, CarModel, CarType, FuelType...
├── Policies/                  # CarPolicy, UserPolicy
└── Services/                  # CarImageService, PdfService

routes/
├── api.php                    # Rutas REST (Sanctum)
└── web.php                    # Rutas web (Breeze)
```

### Flujo de autenticación

```
Web  ──► Breeze (sesión) ──► Middleware Verified ──► Rutas autenticadas
API  ──► Sanctum token   ──► auth:sanctum         ──► Rutas /api/*
                                                    └► Rol admin ──► /admin/*
```

---

## 🚀 Instalación

### Requisitos previos

- PHP 8.2+
- Composer
- Node.js 18+ y npm
- MySQL 8+

### Pasos

```bash
# 1. Clonar el repositorio
git clone <repo-url> segunda-marcha
cd segunda-marcha

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
npm install

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Crear la base de datos en MySQL
# CREATE DATABASE laravel_coches;

# 6. Ejecutar migraciones y seeders
php artisan migrate --seed

# 7. (Opcional) Crear la base de datos de tests
# CREATE DATABASE laravel_coches_test;

# 8. Arrancar el servidor
php artisan serve    # → http://localhost:8000
npm run dev          # → hot reload de assets
```

> **Nota:** Si los estilos aparecen en blanco, ejecuta `npm run build` antes de servir.

---

## ⚙️ Variables de entorno

Copia `.env.example` a `.env` y ajusta los siguientes valores clave:

```ini
APP_NAME="Segunda Marcha"
APP_URL=http://localhost:8000

DB_DATABASE=laravel_coches
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database   # Jobs asíncronos (emails)
CACHE_STORE=database
SESSION_DRIVER=file

MAIL_MAILER=log             # En desarrollo: imprime en storage/logs/laravel.log
```

Para procesar la cola de emails en desarrollo:

```bash
php artisan queue:work
```

---

## 🗄 Base de datos

### Modelos y relaciones principales

```
User ──────────────────────── Car (HasMany: coches propios)
  └─ BelongsToMany ──────────── Car (favoritos, con notas y added_at)

Car ──┬─ BelongsTo ──────────── Maker
      ├─ BelongsTo ──────────── CarModel
      ├─ BelongsTo ──────────── CarType
      ├─ BelongsTo ──────────── FuelType
      ├─ BelongsTo ──────────── City ──► State
      ├─ HasMany ────────────── CarImages  (multi-imagen + posición)
      └─ HasMany ────────────── CarFeatures
```

### Tablas principales

| Tabla | Descripción |
|-------|-------------|
| `users` | Usuarios con campo `rol` (user / admin) |
| `cars` | Anuncios con `published_at` nullable |
| `car_makers` | Marcas (Toyota, Ford, BMW…) |
| `models` | Modelos por marca |
| `car_types` | 9 tipos de carrocería |
| `fuel_types` | 4 tipos de combustible |
| `car_images` | Imágenes ordenadas por `position` |
| `favourite_cars` | Pivot con `notes` y `added_at` |
| `states` / `cities` | Geografía de ubicación |

> La tabla `cars` tiene índices en `published_at`, `user_id`, `maker_id`, `fuel_type_id` y `city_id` para consultas rápidas.

---

## 🌐 API REST

La API está disponible en `/api` y documentada con Swagger en:

```
GET /api/documentation
```

### Endpoints públicos

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| `POST` | `/api/auth/register` | Registro + token |
| `POST` | `/api/auth/login` | Login + token |
| `GET` | `/api/cars` | Listado con filtros |
| `GET` | `/api/cars/{id}` | Detalle de vehículo |
| `GET` | `/api/catalog/makers` | Marcas disponibles |
| `GET` | `/api/catalog/fuel-types` | Tipos de combustible |
| `GET` | `/api/catalog/car-types` | Tipos de carrocería |

### Endpoints protegidos `(Bearer token)`

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| `POST` | `/api/auth/logout` | Invalidar token |
| `GET` | `/api/auth/me` | Usuario autenticado |
| `GET` | `/api/user/favourites` | Coches favoritos |
| `POST` | `/api/cars` | Crear anuncio |
| `PUT` | `/api/cars/{id}` | Editar anuncio |
| `DELETE` | `/api/cars/{id}` | Eliminar anuncio |
| `POST` | `/api/cars/{id}/favourite` | Alternar favorito |

### Ejemplo de petición

```bash
# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Respuesta
{
  "token": "1|abc123...",
  "user": { "id": 1, "name": "...", "email": "..." }
}

# Usar el token
curl http://localhost:8000/api/user/favourites \
  -H "Authorization: Bearer 1|abc123..."
```

---

## ⚡ Componentes Livewire

| Componente | Descripción |
|-----------|-------------|
| `CarSearch` | Buscador + filtros en tiempo real en la home |
| `CarImages` | Subida, previsualización y reordenación de imágenes |
| `FavouriteButton` | Toggle de favorito instantáneo por coche |
| `FavouritesList` | Lista de favoritos del usuario con notas editables |
| `AdminUsers` | Tabla administrativa: gestión de usuarios y roles |

---

## 🔧 Comandos Artisan

```bash
# Publicar coches en estado borrador
php artisan app:publish-pending-cars

# Eliminar borradores antiguos sin publicar
php artisan app:clean-old-drafts

# Ver estadísticas del sistema
php artisan app:cars-stats
```

---

## 🧪 Tests

```bash
# Ejecutar la suite completa
php artisan test

# Con cobertura
php artisan test --coverage

# Solo un grupo
php artisan test --filter=CarApiTest
```

### Cobertura actual

| Métrica | Valor |
|---------|-------|
| Clases | 68.12 % |
| Métodos | 80.81 % |
| **Líneas** | **85.58 %** |

### Estructura de tests

```
tests/
├── Feature/
│   ├── Auth/          # Registro, login, reset, verificación
│   ├── Api/           # AuthApiTest, CarApiTest, FavouriteApiTest...
│   ├── Web/           # CarWebTest, ProfileWebTest, DashboardTest...
│   ├── LivewireTest.php
│   ├── LocaleTest.php
│   ├── CarModelTest.php
│   └── PolicyTest.php
└── Unit/
    └── ExampleTest.php
```

> Los tests usan base de datos real (`laravel_coches_test`), sin mocks de DB, para garantizar que las migraciones y queries funcionan tal como en producción.

---

## 📦 Despliegue

```bash
# Compilar assets para producción
npm run build

# Optimizar autoloader y config
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones en producción
php artisan migrate --force

# Procesar colas (recomendado con Supervisor)
php artisan queue:work --tries=3
```

---

## 📁 Estructura de directorios clave

```
.
├── app/
├── bootstrap/
├── config/
│   └── l5-swagger.php         # Configuración Swagger
├── database/
│   ├── migrations/            # 18 migraciones
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── livewire/          # Vistas de componentes
│   │   ├── cars/
│   │   ├── admin/
│   │   └── pdfs/              # Plantillas PDF
│   ├── css/
│   └── js/
├── routes/
│   ├── api.php
│   └── web.php
├── tests/
├── .env.example
├── composer.json
├── package.json
├── phpunit.xml
└── vite.config.js
```

---

## 📄 Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).

---

<div align="center">

Desarrollado con ❤️ usando **Laravel 12** · **Livewire 4** · **Tailwind CSS 3**

</div>
