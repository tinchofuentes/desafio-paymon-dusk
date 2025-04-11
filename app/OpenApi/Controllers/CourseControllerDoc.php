<?php

namespace App\OpenApi\Controllers;

use App\OpenApi\ApiDocumentation;

/**
 * @OA\Tag(
 *     name="Courses",
 *     description="API Endpoints de gestión de cursos"
 * )
 */
class CourseControllerDoc implements ApiDocumentation
{
    /**
     * Get all OpenAPI annotations for the CourseController
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
     *     path="/courses",
     *     operationId="getCoursesList",
     *     tags={"Courses"},
     *     summary="Obtener listado de cursos",
     *     description="Retorna un listado paginado de cursos",
     *     @OA\Parameter(
     *         name="academy_id",
     *         in="query",
     *         description="Filtrar por academia",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="active",
     *         in="query",
     *         description="Filtrar por cursos activos/inactivos",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_academy",
     *         in="query",
     *         description="Incluir academia relacionada",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_counts",
     *         in="query",
     *         description="Incluir conteos de matrículas",
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
     *                 @OA\Items(ref="#/components/schemas/Course")
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
     *     path="/courses",
     *     operationId="storeCourse",
     *     tags={"Courses"},
     *     summary="Crear un nuevo curso",
     *     description="Crea un nuevo curso en la base de datos",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "academy_id", "cost", "duration", "modality"},
     *             @OA\Property(property="name", type="string", example="Piano para principiantes"),
     *             @OA\Property(property="description", type="string", example="Curso básico de piano"),
     *             @OA\Property(property="academy_id", type="integer", example=1),
     *             @OA\Property(property="cost", type="number", format="float", example=150.00),
     *             @OA\Property(property="duration", type="integer", example=20),
     *             @OA\Property(property="modality", type="string", enum={"in-person", "online", "hybrid"}, example="in-person"),
     *             @OA\Property(property="active", type="boolean", example=true),
     *             @OA\Property(property="capacity", type="integer", example=15),
     *             @OA\Property(property="start_date", type="string", format="date", example="2023-05-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2023-06-15")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Curso creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Course"
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
     *     path="/courses/{id}",
     *     operationId="getCourse",
     *     tags={"Courses"},
     *     summary="Obtener detalle de un curso",
     *     description="Retorna los datos de un curso específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del curso",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="with_academy",
     *         in="query",
     *         description="Incluir academia relacionada",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_counts",
     *         in="query",
     *         description="Incluir conteos de matrículas",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Course"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Curso no encontrado"
     *     )
     * )
     */
    public static function showEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Put(
     *     path="/courses/{id}",
     *     operationId="updateCourse",
     *     tags={"Courses"},
     *     summary="Actualizar un curso existente",
     *     description="Actualiza un curso existente en la base de datos",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del curso",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Piano nivel avanzado"),
     *             @OA\Property(property="description", type="string", example="Curso avanzado de piano"),
     *             @OA\Property(property="cost", type="number", format="float", example=200.00),
     *             @OA\Property(property="duration", type="integer", example=25),
     *             @OA\Property(property="modality", type="string", enum={"in-person", "online", "hybrid"}, example="in-person"),
     *             @OA\Property(property="active", type="boolean", example=true),
     *             @OA\Property(property="capacity", type="integer", example=10),
     *             @OA\Property(property="start_date", type="string", format="date", example="2023-07-01"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2023-08-15")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Curso actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Course"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Curso no encontrado"
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
     *     path="/courses/{id}",
     *     operationId="deleteCourse",
     *     tags={"Courses"},
     *     summary="Eliminar un curso",
     *     description="Elimina un curso existente",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del curso",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Curso eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Curso no encontrado"
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