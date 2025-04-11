<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Course",
 *     required={"id", "name", "academy_id", "cost", "duration", "modality", "active"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Piano para principiantes"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Curso básico de piano para personas sin experiencia previa"
 *     ),
 *     @OA\Property(
 *         property="academy_id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="cost",
 *         type="number",
 *         format="float",
 *         example=150.00
 *     ),
 *     @OA\Property(
 *         property="duration",
 *         type="integer",
 *         example=20,
 *         description="Duración en horas"
 *     ),
 *     @OA\Property(
 *         property="modality",
 *         type="object",
 *         @OA\Property(
 *             property="value",
 *             type="string",
 *             enum={"in-person", "online", "hybrid"},
 *             example="in-person"
 *         ),
 *         @OA\Property(
 *             property="label",
 *             type="string",
 *             example="Presencial"
 *         )
 *     ),
 *     @OA\Property(
 *         property="active",
 *         type="boolean",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="capacity",
 *         type="integer",
 *         example=15
 *     ),
 *     @OA\Property(
 *         property="start_date",
 *         type="string",
 *         format="date",
 *         example="2023-05-01"
 *     ),
 *     @OA\Property(
 *         property="end_date",
 *         type="string",
 *         format="date",
 *         example="2023-06-15"
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
 *         property="academy",
 *         nullable=true,
 *         allOf={
 *             @OA\Schema(ref="#/components/schemas/Academy")
 *         }
 *     ),
 *     @OA\Property(
 *         property="enrollments_count",
 *         type="integer",
 *         example=8,
 *         nullable=true
 *     )
 * )
 */
class CourseSchema
{
    // Esta clase solo se utiliza para la documentación de OpenAPI
} 