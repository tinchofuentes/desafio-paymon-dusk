<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Guardian",
 *     required={"id", "name", "email"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Ana Martínez"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="ana.martinez@example.com"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         example="+34612345678"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         example="2023-01-01T12:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         example="2023-01-01T13:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="students",
 *         type="array",
 *         nullable=true,
 *         @OA\Items(ref="#/components/schemas/Student")
 *     )
 * )
 */
class GuardianSchema
{
    // Esta clase solo se utiliza para la documentación de OpenAPI
} 