<?php

namespace App\OpenApi\Controllers;

use App\OpenApi\ApiDocumentation;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints de autenticación"
 * )
 */
class AuthControllerDoc implements ApiDocumentation
{
    /**
     * Get all OpenAPI annotations for the AuthController
     */
    public static function getAnnotations(): array
    {
        return [
            self::loginEndpoint(),
            self::logoutEndpoint(),
            self::userEndpoint(),
        ];
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     operationId="login",
     *     tags={"Authentication"},
     *     summary="Iniciar sesión y obtener token",
     *     description="Autentica un usuario y retorna un token de acceso",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="usuario@ejemplo.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Autenticación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="token", 
     *                 type="string", 
     *                 example="1|laravel_sanctum_tokendK6mVqwSd23hf8eFuXPQ5XUFcUAsXM8a5XTl49Ld"
     *             ),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="email", type="string", format="email", example="usuario@ejemplo.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos no válidos o credenciales incorrectas"
     *     )
     * )
     */
    public static function loginEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     operationId="logout",
     *     tags={"Authentication"},
     *     summary="Cerrar sesión",
     *     description="Revoca el token de acceso del usuario autenticado",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sesión cerrada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Sesión cerrada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public static function logoutEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Get(
     *     path="/auth/user",
     *     operationId="getUser",
     *     tags={"Authentication"},
     *     summary="Obtener datos del usuario autenticado",
     *     description="Retorna la información del usuario autenticado",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="email", type="string", format="email", example="usuario@ejemplo.com"),
     *                 @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public static function userEndpoint(): string
    {
        return "";
    }
} 