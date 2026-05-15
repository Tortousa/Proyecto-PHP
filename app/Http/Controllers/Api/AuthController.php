<?php

namespace App\Http\Controllers\Api;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\ApiResponses;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controlador de autenticación para la API.
// Gestiona registro (con email de bienvenida vía evento), login, logout y datos del usuario actual.
class AuthController extends Controller
{
    // Importa el método $this->success() que envuelve toda respuesta en {data, meta}
    use ApiResponses;

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => $request->password,
        ]);

        // El evento dispara SendWelcomeMail → SendWelcomeEmailJob (cola)
        UserRegistered::dispatch($user);

        $token = $user->createToken('api-token')->plainTextToken;

        // data → usuario transformado por UserResource + token de Sanctum
        // meta → mensaje legible para el cliente
        // 201  → HTTP Created (recurso creado correctamente)
        return $this->success(
            ['user' => new UserResource($user), 'token' => $token],
            ['message' => 'Usuario registrado correctamente.'],
            201
        );
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            // data → null porque no hay recurso que devolver en caso de error
            // meta → mensaje de error para mostrar al usuario
            // 401  → HTTP Unauthorized
            return $this->success(null, ['message' => 'Credenciales incorrectas.'], 401);
        }

        $user  = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        // data → usuario + token (el cliente los necesita para las siguientes peticiones)
        return $this->success(['user' => new UserResource($user), 'token' => $token]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        // data → null porque al cerrar sesión no hay recurso que devolver
        return $this->success(null, ['message' => 'Sesión cerrada correctamente.']);
    }

    public function user(Request $request): JsonResponse
    {
        // data → usuario autenticado transformado por UserResource (oculta password, etc.)
        return $this->success(new UserResource($request->user()));
    }
}
