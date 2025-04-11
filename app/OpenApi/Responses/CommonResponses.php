<?php

namespace App\OpenApi\Responses;

/**
 * @OA\Response(
 *     response="404",
 *     description="Recurso no encontrado"
 * )
 * 
 * @OA\Response(
 *     response="401",
 *     description="No autorizado"
 * )
 * 
 * @OA\Response(
 *     response="403",
 *     description="Prohibido - No tiene permisos"
 * )
 * 
 * @OA\Response(
 *     response="422",
 *     description="Error de validación",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="Los datos proporcionados no son válidos"),
 *         @OA\Property(
 *             property="errors",
 *             type="object",
 *             example={"campo1": {"El campo es requerido"}, "campo2": {"El formato es inválido"}}
 *         )
 *     )
 * )
 * 
 * @OA\Response(
 *     response="500",
 *     description="Error del servidor",
 *     @OA\JsonContent(
 *         @OA\Property(property="message", type="string", example="Error interno del servidor")
 *     )
 * )
 * 
 * @OA\Response(
 *     response="204",
 *     description="Sin contenido - Operación exitosa"
 * )
 * 
 * @OA\Response(
 *     response="PaginatedResponse",
 *     description="Respuesta paginada exitosa",
 *     @OA\JsonContent(
 *         type="object",
 *         @OA\Property(
 *             property="data",
 *             type="array",
 *             @OA\Items(type="object")
 *         ),
 *         @OA\Property(
 *             property="links",
 *             type="object",
 *             @OA\Property(property="first", type="string", example="http://example.com/api/resource?page=1"),
 *             @OA\Property(property="last", type="string", example="http://example.com/api/resource?page=5"),
 *             @OA\Property(property="prev", type="string", example="http://example.com/api/resource?page=1"),
 *             @OA\Property(property="next", type="string", example="http://example.com/api/resource?page=3")
 *         ),
 *         @OA\Property(
 *             property="meta",
 *             type="object",
 *             @OA\Property(property="current_page", type="integer", example=2),
 *             @OA\Property(property="from", type="integer", example=16),
 *             @OA\Property(property="last_page", type="integer", example=5),
 *             @OA\Property(property="path", type="string", example="http://example.com/api/resource"),
 *             @OA\Property(property="per_page", type="integer", example=15),
 *             @OA\Property(property="to", type="integer", example=30),
 *             @OA\Property(property="total", type="integer", example=75)
 *         )
 *     )
 * )
 */
class CommonResponses
{
    // Esta clase es solo para documentación OpenAPI
} 