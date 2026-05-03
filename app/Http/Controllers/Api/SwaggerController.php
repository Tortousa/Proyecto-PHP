<?php

namespace App\Http\Controllers\Api;

// Este archivo no es un controlador real — solo existe para que Swagger
// encuentre las anotaciones de configuración general de la API en un sitio fijo.
// Las anotaciones de cada endpoint van en su propio controlador.

/**
 * @OA\Info(
 *     title="Proyecto PHP — API de coches",
 *     version="1.0.0",
 *     description="API REST para el marketplace de compraventa de coches. Permite listar anuncios públicamente, autenticarse con Sanctum y gestionar coches y favoritos."
 * )
 *
 * @OA\Server(
 *     url="/api",
 *     description="Servidor local"
 * )
 *
 * @OA\PathItem(path="/")
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Token Sanctum obtenido en /auth/login o /auth/register"
 * )
 */
class SwaggerController {}
