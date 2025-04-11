<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Student",
 *     required={"id", "first_name", "last_name", "birth_date"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         example="Juan"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         example="Pérez"
 *     ),
 *     @OA\Property(
 *         property="birth_date",
 *         type="string",
 *         format="date",
 *         example="2010-05-15"
 *     ),
 *     @OA\Property(
 *         property="gender",
 *         type="string",
 *         enum={"male", "female", "other"},
 *         nullable=true,
 *         example="male"
 *     ),
 *     @OA\Property(
 *         property="guardian_id",
 *         type="integer",
 *         format="int64",
 *         example=1
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
 *         property="guardian",
 *         nullable=true,
 *         allOf={
 *             @OA\Schema(ref="#/components/schemas/Guardian")
 *         }
 *     ),
 *     @OA\Property(
 *         property="enrollments",
 *         type="array",
 *         nullable=true,
 *         @OA\Items(ref="#/components/schemas/Enrollment")
 *     )
 * )
 */
class StudentSchema
{
    // Esta clase solo se utiliza para la documentación de OpenAPI
} 