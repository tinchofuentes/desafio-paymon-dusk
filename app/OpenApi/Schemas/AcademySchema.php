<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Academy",
 *     required={"id", "name", "active"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Academia de Música"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Aprende a tocar instrumentos musicales"
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="boolean",
 *         example=true
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
 *         property="courses",
 *         type="array",
 *         nullable=true,
 *         @OA\Items(ref="#/components/schemas/Course")
 *     ),
 *     @OA\Property(
 *         property="courses_count",
 *         type="integer",
 *         example=3,
 *         nullable=true
 *     )
 * )
 */
class AcademySchema
{
    // Esta clase solo se utiliza para la documentación de OpenAPI
} 