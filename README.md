<h1 align="center">🚗 AutoMarket — Plataforma de Compraventa de Vehículos</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white"/>
  <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/Livewire-4-FB70A9?style=for-the-badge&logo=livewire&logoColor=white"/>
  <img src="https://img.shields.io/badge/Sanctum-API-4A90E2?style=for-the-badge"/>
  <img src="https://img.shields.io/badge/Tests-102%20%E2%9C%85-brightgreen?style=for-the-badge"/>
  <img src="https://img.shields.io/badge/Cobertura-85%25-success?style=for-the-badge"/>
</p>

<p align="center">
  Aplicación web full-stack para publicar, buscar y gestionar anuncios de coches.<br/>
  API REST documentada con Swagger · Autenticación con Sanctum · Panel de administración · Notificaciones por email
</p>

---

## ✨ Características principales

| Módulo | Descripción |
|--------|-------------|
| 🔐 **Autenticación** | Registro/login con Laravel Breeze · verificación de email · tokens Sanctum para la API |
| 🚘 **Gestión de coches** | CRUD completo con imágenes, características, tipo de combustible, marca y ciudad |
| ❤️ **Favoritos** | Guarda y gestiona los anuncios que más te interesan |
| 🛡️ **Policies** | Control de acceso por propietario y rol (admin/user) |
| 👤 **Panel admin** | CRUD de usuarios, asignación de roles y gestión de anuncios |
| 🌐 **API REST** | Endpoints públicos y protegidos, paginación, resources y catálogos |
| 📬 **Notificaciones** | Emails automáticos con Events, Listeners y Jobs en cola |
| 📄 **PDF** | Exportación de fichas de vehículos con DomPDF |
| 🌍 **Multiidioma** | Soporte ES/EN con middleware de idioma |
| ⚡ **Livewire** | Componentes reactivos sin recargar la página |
| 🧪 **Tests** | 102 tests con Pest · 85% de cobertura de código |

---

## 🗂️ Estructura de la API

### Endpoints públicos

```
GET  /api/cars               → Listado paginado de coches
GET  /api/cars/{id}          → Detalle de un coche
GET  /api/catalog/makers     → Marcas disponibles
GET  /api/catalog/fuel-types → Tipos de combustible
GET  /api/catalog/car-types  → Tipos de vehículo
POST /api/auth/register      → Registro de usuario
POST /api/auth/login         → Login → devuelve token
```

### Endpoints protegidos `Bearer Token`

```
GET    /api/user/me              → Datos del usuario autenticado
GET    /api/user/favourites      → Favoritos del usuario
POST   /api/cars                 → Publicar anuncio
PUT    /api/cars/{id}            → Editar anuncio propio
DELETE /api/cars/{id}            → Eliminar anuncio propio
POST   /api/cars/{id}/favourite  → Añadir/quitar favorito
POST   /api/auth/logout          → Cerrar sesión (revoca token)
```

---

## 🏗️ Stack tecnológico

- **Backend:** Laravel 12 · PHP 8.2
- **Frontend:** Blade · Tailwind CSS · Livewire 4
- **Autenticación:** Laravel Breeze + Laravel Sanctum
- **Base de datos:** MySQL
- **Testing:** Pest PHP · 102 tests · 85% cobertura
- **Colas:** Laravel Jobs (emails asíncronos)
- **PDF:** barryvdh/laravel-dompdf
- **Docs API:** darkaonline/l5-swagger

---

## ⚙️ Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/Tortousa/Proyecto-PHP.git
cd Proyecto-PHP

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Configurar base de datos en .env y ejecutar migraciones
php artisan migrate --seed

# 5. Compilar assets
npm run build

# 6. Arrancar el servidor
php artisan serve
```

---

## 🧪 Tests

```bash
# Ejecutar todos los tests
php artisan test

# Con cobertura de código
php artisan test --coverage
```

> **102 tests · 85% de cobertura** — incluyendo tests de modelos, controladores, API, policies, jobs y eventos.

---

## 📁 Arquitectura

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/          # Controladores REST (Car, Auth, User, Catalogue, Favourite)
│   │   └── Web/          # Controladores web (Car, Admin, Profile...)
│   ├── Requests/         # Form Requests con validación
│   └── Resources/        # API Resources (CarResource, CarSummaryResource...)
├── Models/               # Car, User, Maker, CarType, FuelType, City...
├── Policies/             # CarPolicy, UserPolicy
├── Events/               # CarPublished, UserRegistered
├── Listeners/            # NotifyCarPublished, SendWelcomeMail
├── Jobs/                 # SendCarPublishedEmailJob, SendWelcomeEmailJob
├── Services/             # CarImageService, PdfService
└── Livewire/             # Componentes reactivos
```

---

## 👤 Autor

**Daniel Tortosa** · 2º DAW · Desarrollo de Aplicaciones Web

---

<p align="center">Hecho con ❤️ y Laravel</p>
