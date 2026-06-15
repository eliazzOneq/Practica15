<?php

namespace App\Http\Controllers\Api\V1;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rol' => $user->rol,
            'permisos' => [
                'crear' => Gate::allows('crear-producto'),
                'editar' => Gate::allows('editar-producto'),
                'eliminar' => Gate::allows('eliminar-producto'),
            ],
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'rol' => $request->rol
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    #[OA\Post(
        path: '/api/v1/login',
        summary: 'Iniciar sesión',
        tags: ['Autenticación']
        )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['email','password'],
            properties: [
                new OA\Property(property: 'email', type: 'string'),
                new OA\Property(property: 'password', type: 'string')
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: 'Login correcto'
    )]
    #[OA\Response(
        response: 401,
        description: 'Credenciales inválidas'
    )]
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where(
            'email',
            $request->email
        )->first();

        if (
            !$user ||
            !Hash::check(
                $request->password,
                $user->password
            )
        ) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas']
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'message' => 'Sesión cerrada'
        ]);
    }
}