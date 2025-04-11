<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Enrollment",
 *     required={"id", "student_id", "course_id", "enrollment_date", "status"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="student_id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="course_id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="enrollment_date",
 *         type="string",
 *         format="date",
 *         example="2023-05-01"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="object",
 *         @OA\Property(
 *             property="value",
 *             type="string",
 *             enum={"pending", "active", "completed", "cancelled"},
 *             example="active"
 *         ),
 *         @OA\Property(
 *             property="label",
 *             type="string",
 *             example="Activa"
 *         )
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="string",
 *         nullable=true,
 *         example="El estudiante requiere atención especial"
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
 *         property="student",
 *         nullable=true,
 *         allOf={
 *             @OA\Schema(ref="#/components/schemas/Student")
 *         }
 *     ),
 *     @OA\Property(
 *         property="course",
 *         nullable=true,
 *         allOf={
 *             @OA\Schema(ref="#/components/schemas/Course")
 *         }
 *     ),
 *     @OA\Property(
 *         property="payments",
 *         type="array",
 *         nullable=true,
 *         @OA\Items(ref="#/components/schemas/Payment")
 *     )
 * )
 */
class EnrollmentSchema
{
    // Esta clase solo se utiliza para la documentación de OpenAPI
} 