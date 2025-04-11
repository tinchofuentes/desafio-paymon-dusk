<?php

namespace App\OpenApi\Components;

/**
 * @OA\RequestBody(
 *     request="EnrollmentRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         required={"course_id", "student_id", "enrollment_date"},
 *         @OA\Property(property="course_id", type="integer", example=1),
 *         @OA\Property(property="student_id", type="integer", example=1),
 *         @OA\Property(property="enrollment_date", type="string", format="date", example="2023-05-01"),
 *         @OA\Property(property="notes", type="string", example="El estudiante requiere atención especial"),
 *         @OA\Property(property="guardian_id", type="integer", example=1),
 *         @OA\Property(property="initial_payment", type="number", format="float", example=50.00),
 *         @OA\Property(property="payment_method", type="string", enum={"cash", "bank_transfer"}, example="cash")
 *     )
 * )
 *
 * @OA\RequestBody(
 *     request="CourseRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         required={"name", "academy_id", "cost", "duration", "modality"},
 *         @OA\Property(property="name", type="string", example="Piano para principiantes"),
 *         @OA\Property(property="description", type="string", example="Curso básico de piano"),
 *         @OA\Property(property="academy_id", type="integer", example=1),
 *         @OA\Property(property="cost", type="number", format="float", example=150.00),
 *         @OA\Property(property="duration", type="integer", example=20),
 *         @OA\Property(property="modality", type="string", enum={"in-person", "online", "hybrid"}, example="in-person"),
 *         @OA\Property(property="active", type="boolean", example=true),
 *         @OA\Property(property="capacity", type="integer", example=15),
 *         @OA\Property(property="start_date", type="string", format="date", example="2023-05-01"),
 *         @OA\Property(property="end_date", type="string", format="date", example="2023-06-15")
 *     )
 * )
 * 
 * @OA\RequestBody(
 *     request="CommunicationRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         required={"course_id", "title", "message", "send_date"},
 *         @OA\Property(property="course_id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Reunión de padres"),
 *         @OA\Property(property="message", type="string", example="Se convoca a todos los padres a una reunión el próximo martes"),
 *         @OA\Property(property="send_date", type="string", format="date-time", example="2023-05-15T18:00:00"),
 *         @OA\Property(property="status", type="string", enum={"draft", "sent", "scheduled"}, example="scheduled"),
 *         @OA\Property(property="send_now", type="boolean", example=false)
 *     )
 * )
 * 
 * @OA\RequestBody(
 *     request="AcademyRequest",
 *     required=true,
 *     @OA\JsonContent(
 *         required={"name"},
 *         @OA\Property(property="name", type="string", example="Academia de Música"),
 *         @OA\Property(property="description", type="string", example="Aprende a tocar instrumentos musicales"),
 *         @OA\Property(property="active", type="boolean", example=true)
 *     )
 * )
 */
class RequestBodies
{
    // Esta clase es solo para documentación OpenAPI
} 