<?php

namespace App\OpenApi\Controllers;

use App\OpenApi\ApiDocumentation;

/**
 * @OA\Tag(
 *     name="Enrollments",
 *     description="API Endpoints de gestión de matrículas"
 * )
 */
class EnrollmentControllerDoc implements ApiDocumentation
{
    /**
     * Get all OpenAPI annotations for the EnrollmentController
     */
    public static function getAnnotations(): array
    {
        return [
            self::indexEndpoint(),
            self::storeEndpoint(),
            self::showEndpoint(),
            self::updateEndpoint(),
            self::destroyEndpoint(),
        ];
    }

    /**
     * @OA\Get(
     *     path="/enrollments",
     *     operationId="getEnrollmentsList",
     *     tags={"Enrollments"},
     *     summary="Obtener listado de matrículas",
     *     description="Retorna un listado paginado de matrículas",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="course_id",
     *         in="query",
     *         description="Filtrar por curso",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filtrar por estado de la matrícula",
     *         required=false,
     *         @OA\Schema(type="string", enum={"pending", "confirmed", "cancelled"})
     *     ),
     *     @OA\Parameter(
     *         name="from_date",
     *         in="query",
     *         description="Filtrar desde fecha (formato Y-m-d)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="to_date",
     *         in="query",
     *         description="Filtrar hasta fecha (formato Y-m-d)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="with_student",
     *         in="query",
     *         description="Incluir estudiante relacionado",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_course",
     *         in="query",
     *         description="Incluir curso relacionado",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_payments",
     *         in="query",
     *         description="Incluir pagos relacionados",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Número de resultados por página",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Enrollment")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public static function indexEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Post(
     *     path="/enrollments",
     *     operationId="storeEnrollment",
     *     tags={"Enrollments"},
     *     summary="Crear una nueva matrícula",
     *     description="Crea una nueva matrícula en la base de datos",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"guardian_name", "guardian_email", "guardian_phone", "student_first_name", "student_last_name", "student_birth_date", "course_id", "payment_method"},
     *             @OA\Property(property="guardian_name", type="string", example="Juan Pérez"),
     *             @OA\Property(property="guardian_email", type="string", format="email", example="juan.perez@example.com"),
     *             @OA\Property(property="guardian_phone", type="string", example="+56 9 1234 5678"),
     *             @OA\Property(property="student_first_name", type="string", example="María"),
     *             @OA\Property(property="student_last_name", type="string", example="Pérez"),
     *             @OA\Property(property="student_birth_date", type="string", format="date", example="2010-01-15"),
     *             @OA\Property(property="student_gender", type="string", enum={"male", "female", "other"}, example="female"),
     *             @OA\Property(property="course_id", type="integer", example=1),
     *             @OA\Property(property="enrollment_date", type="string", format="date", example="2023-05-01"),
     *             @OA\Property(property="notes", type="string", example="La estudiante tiene experiencia previa en piano."),
     *             @OA\Property(property="status", type="string", enum={"pending", "confirmed", "cancelled"}, example="pending"),
     *             @OA\Property(property="payment_method", type="string", enum={"cash", "bank_transfer"}, example="cash"),
     *             @OA\Property(property="payment_amount", type="number", format="float", example=150.00),
     *             @OA\Property(property="payment_status", type="string", enum={"pending", "completed", "failed", "refunded"}, example="pending"),
     *             @OA\Property(property="reference_number", type="string", example="TRX-12345")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Matrícula creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Enrollment"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public static function storeEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Get(
     *     path="/enrollments/{enrollment}",
     *     operationId="getEnrollment",
     *     tags={"Enrollments"},
     *     summary="Obtener detalles de una matrícula",
     *     description="Retorna los detalles de una matrícula específica",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="enrollment",
     *         in="path",
     *         description="ID de la matrícula",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="with_student",
     *         in="query",
     *         description="Incluir estudiante relacionado",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_course",
     *         in="query",
     *         description="Incluir curso relacionado",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_payments",
     *         in="query",
     *         description="Incluir pagos relacionados",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Enrollment")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Matrícula no encontrada"
     *     )
     * )
     */
    public static function showEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Put(
     *     path="/enrollments/{enrollment}",
     *     operationId="updateEnrollment",
     *     tags={"Enrollments"},
     *     summary="Actualizar una matrícula existente",
     *     description="Actualiza una matrícula existente en la base de datos",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="enrollment",
     *         in="path",
     *         description="ID de la matrícula",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="guardian_name", type="string", example="Juan Pérez Actualizado"),
     *             @OA\Property(property="guardian_email", type="string", format="email", example="juan.perez.nuevo@example.com"),
     *             @OA\Property(property="guardian_phone", type="string", example="+56 9 8765 4321"),
     *             @OA\Property(property="student_first_name", type="string", example="María Actualizada"),
     *             @OA\Property(property="student_last_name", type="string", example="Pérez Actualizada"),
     *             @OA\Property(property="student_birth_date", type="string", format="date", example="2010-02-20"),
     *             @OA\Property(property="student_gender", type="string", enum={"male", "female", "other"}, example="female"),
     *             @OA\Property(property="course_id", type="integer", example=2),
     *             @OA\Property(property="enrollment_date", type="string", format="date", example="2023-06-01"),
     *             @OA\Property(property="notes", type="string", example="La estudiante ha progresado muy bien."),
     *             @OA\Property(property="status", type="string", enum={"pending", "confirmed", "cancelled"}, example="confirmed"),
     *             @OA\Property(property="payment_method", type="string", enum={"cash", "bank_transfer"}, example="bank_transfer"),
     *             @OA\Property(property="payment_amount", type="number", format="float", example=200.00),
     *             @OA\Property(property="payment_status", type="string", enum={"pending", "completed", "failed", "refunded"}, example="completed"),
     *             @OA\Property(property="reference_number", type="string", example="TRX-67890")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Matrícula actualizada exitosamente",
     *         @OA\JsonContent(ref="#/components/schemas/Enrollment")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Matrícula no encontrada"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public static function updateEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Delete(
     *     path="/enrollments/{enrollment}",
     *     operationId="deleteEnrollment",
     *     tags={"Enrollments"},
     *     summary="Eliminar una matrícula",
     *     description="Elimina una matrícula existente",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="enrollment",
     *         in="path",
     *         description="ID de la matrícula",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Matrícula eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Matrícula no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public static function destroyEndpoint(): string
    {
        return "";
    }
} 