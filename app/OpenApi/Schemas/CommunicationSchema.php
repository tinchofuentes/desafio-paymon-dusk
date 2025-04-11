<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Communication",
 *     required={"id", "course_id", "title", "message", "send_date", "status"},
 *     @OA\Property(
 *         property="id",
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
 *         property="title",
 *         type="string",
 *         example="Reunión de padres"
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         example="Se convoca a todos los padres a una reunión el próximo martes"
 *     ),
 *     @OA\Property(
 *         property="send_date",
 *         type="string",
 *         format="date-time",
 *         example="2023-05-15T18:00:00Z"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"draft", "sent", "scheduled"},
 *         example="scheduled"
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
 *         property="course",
 *         nullable=true,
 *         allOf={
 *             @OA\Schema(ref="#/components/schemas/Course")
 *         }
 *     ),
 *     @OA\Property(
 *         property="guardians",
 *         type="array",
 *         nullable=true,
 *         @OA\Items(ref="#/components/schemas/Guardian")
 *     ),
 *     @OA\Property(
 *         property="guardians_count",
 *         type="integer",
 *         example=12,
 *         nullable=true
 *     )
 * )
 */
class CommunicationSchema
{
    // Esta clase solo se utiliza para la documentación de OpenAPI
} 