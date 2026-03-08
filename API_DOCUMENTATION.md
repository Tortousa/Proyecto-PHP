# API Documentation - Car Marketplace

## Base URL
```
/api
```

## Authentication
The API uses **Laravel Sanctum** for token-based authentication.

### Obtener Token (Login)
**Endpoint:** `POST /api/login`

**Request:**
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
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "user@example.com"
    },
    "token": "1|abcdef123456..."
  }
}
```

### Cerrar Sesión (Logout)
**Endpoint:** `POST /api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Logout successful"
}
```

---

## CRUD 1: Coches (Público - Sin autenticación)

### Listar Coches Publicados
**Endpoint:** `GET /api/cars`

**Query Parameters:**
- `per_page` (int, default: 10) - Resultados por página
- `maker_id` (int) - Filtrar por marca
- `model_id` (int) - Filtrar por modelo
- `city_id` (int) - Filtrar por ciudad
- `price_min` (float) - Precio mínimo
- `price_max` (float) - Precio máximo

**Example:**
```
GET /api/cars?per_page=10&price_min=5000&price_max=50000
```

**Response:**
```json
{
  "success": true,
  "message": "Cars retrieved successfully",
  "data": [
    {
      "id": 1,
      "maker": {
        "id": 1,
        "name": "Toyota"
      },
      "model": {
        "id": 1,
        "name": "Camry"
      },
      "year": 2022,
      "price": 25000,
      "mileage": 50000,
      "vin": "ABC123...",
      "address": "123 Main St",
      "phone": "+1234567890",
      "description": "Well maintained car",
      "car_type": {
        "id": 1,
        "name": "Sedan"
      },
      "fuel_type": {
        "id": 1,
        "name": "Gasoline"
      },
      "city": {
        "id": 1,
        "name": "New York"
      },
      "owner": {
        "id": 1,
        "name": "John Seller",
        "email": "seller@example.com"
      },
      "primary_image": {
        "id": 1,
        "image_path": "cars/...",
        "url": "http://localhost/storage/cars/...",
        "position": 1
      },
      "images": [...],
      "published_at": "2024-03-08T10:00:00Z",
      "created_at": "2024-03-08T10:00:00Z",
      "updated_at": "2024-03-08T10:00:00Z"
    }
  ],
  "pagination": {
    "total": 50,
    "per_page": 10,
    "current_page": 1,
    "last_page": 5
  }
}
```

### Obtener Un Coche Específico
**Endpoint:** `GET /api/cars/{id}`

**Response:**
```json
{
  "success": true,
  "message": "Car retrieved successfully",
  "data": {
    "id": 1,
    "maker": {...},
    "model": {...},
    ...
  }
}
```

---

## CRUD 2: Imágenes de Coches (Autenticado con Sanctum)

> **⚠️ REQUIERE AUTENTICACIÓN** - Se necesita el header `Authorization: Bearer {token}`

### Listar Imágenes del Usuario
**Endpoint:** `GET /api/car-images`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters:**
- `per_page` (int, default: 10)

**Response:**
```json
{
  "success": true,
  "message": "Images retrieved successfully",
  "data": [
    {
      "id": 1,
      "car_id": 1,
      "car": {
        "id": 1,
        "maker_id": 1,
        "model_id": 1
      },
      "image_path": "cars/...",
      "url": "http://localhost/storage/cars/...",
      "position": 1
    }
  ],
  "pagination": {
    "total": 25,
    "per_page": 10,
    "current_page": 1,
    "last_page": 3
  }
}
```

### Obtener Imágenes de Un Coche Específico
**Endpoint:** `GET /api/cars/{car_id}/images`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Car images retrieved successfully",
  "data": [
    {
      "id": 1,
      "car_id": 1,
      "image_path": "cars/...",
      "url": "http://localhost/storage/cars/...",
      "position": 1
    }
  ]
}
```

### Subir Una Imagen
**Endpoint:** `POST /api/car-images` o `POST /api/cars/{car_id}/images`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: multipart/form-data
```

**Body:**
```
- car_id: 1 (required si usa POST /api/car-images)
- image: <archivo> (required, max 5MB, types: jpg, jpeg, png, gif, webp)
- position: 2 (optional, default: next available position)
```

**Response:**
```json
{
  "success": true,
  "message": "Image uploaded successfully",
  "data": {
    "id": 2,
    "car_id": 1,
    "image_path": "cars/xyz789.jpg",
    "url": "http://localhost/storage/cars/xyz789.jpg",
    "position": 2
  }
}
```

### Actualizar Posición de Imagen
**Endpoint:** `PUT /api/car-images/{id}`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Body:**
```json
{
  "position": 3
}
```

**Response:**
```json
{
  "success": true,
  "message": "Image updated successfully",
  "data": {
    "id": 2,
    "car_id": 1,
    "image_path": "cars/xyz789.jpg",
    "url": "http://localhost/storage/cars/xyz789.jpg",
    "position": 3
  }
}
```

### Eliminar Una Imagen
**Endpoint:** `DELETE /api/car-images/{id}` o `DELETE /api/images/{id}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
  "success": true,
  "message": "Image deleted successfully"
}
```

---

## Códigos de Estado HTTP

| Código | Significado |
|--------|-------------|
| 200 | Operación exitosa |
| 201 | Recurso creado exitosamente |
| 400 | Solicitud inválida |
| 401 | No autenticado |
| 403 | No autorizado (acceso denegado) |
| 404 | Recurso no encontrado |
| 422 | Error de validación |
| 500 | Error interno del servidor |

---

## Ejemplo de Uso Completo

### 1. Login
```bash
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password"
  }'
```

### 2. Listar Coches
```bash
curl -X GET "http://localhost/api/cars?per_page=10"
```

### 3. Obtener Detalles de un Coche
```bash
curl -X GET http://localhost/api/cars/1
```

### 4. Subir Imagen (Autenticado)
```bash
curl -X POST http://localhost/api/cars/1/images \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "image=@/path/to/image.jpg"
```

### 5. Logout
```bash
curl -X POST http://localhost/api/logout \
  -H "Authorization: Bearer YOUR_TOKEN"
```

---

## Características Principales

✅ **2 CRUDs Completos:**
- CRUD 1: Coches (lectura pública)
- CRUD 2: Imágenes (gestión autenticada con Sanctum)

✅ **Autenticación con Sanctum:** Tokens seguros basados en la base de datos

✅ **CORS y API Segura:** Middleware de autenticación en rutas sensibles

✅ **Validación robusta:** Validación de input en todos los endpoints

✅ **Recursos formateados:** Respuestas JSON consistentes y bien estructuradas

✅ **Paginación:** Listados paginados para mejor rendimiento
