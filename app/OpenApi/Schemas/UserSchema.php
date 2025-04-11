<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="Modelo de usuario del sistema",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="ID único del usuario",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Nombre completo del usuario",
 *         example="Juan Pérez"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Correo electrónico del usuario",
 *         example="juan.perez@ejemplo.com"
 *     ),
 *     @OA\Property(
 *         property="email_verified_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha y hora de verificación del correo electrónico",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de creación"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Fecha de última actualización"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="UserWithToken",
 *     title="User with Token",
 *     description="Usuario con token de autenticación",
 *     @OA\Property(
 *         property="token",
 *         type="string",
 *         description="Token de autenticación",
 *         example="1|laravel_sanctum_YNdSgA8rCzjbLavVeWOsD1IjGWEeaBZbUbIpPLlx"
 *     ),
 *     @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/User"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="LoginRequest",
 *     title="Login Request",
 *     description="Datos para inicio de sesión",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Correo electrónico del usuario",
 *         example="juan.perez@ejemplo.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         description="Contraseña del usuario",
 *         example="contraseña123"
 *     )
 * )
 */
class UserSchema
{
    // Esta clase solo contiene definiciones OpenAPI
    // No se necesita implementación
} 