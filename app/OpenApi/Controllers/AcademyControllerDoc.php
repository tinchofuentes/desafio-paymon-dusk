<?php

namespace App\OpenApi\Controllers;

use App\OpenApi\ApiDocumentation;

/**
 * @OA\Tag(
 *     name="Academies",
 *     description="API Endpoints de gestión de academias"
 * )
 */
class AcademyControllerDoc implements ApiDocumentation
{
    /**
     * Get all OpenAPI annotations for the AcademyController
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
     *     path="/academies",
     *     operationId="getAcademiesList",
     *     tags={"Academies"},
     *     summary="Obtener listado de academias",
     *     description="Retorna un listado paginado de academias",
     *     @OA\Parameter(
     *         name="active",
     *         in="query",
     *         description="Filtrar por academias activas/inactivas",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_courses",
     *         in="query",
     *         description="Incluir cursos relacionados",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_counts",
     *         in="query",
     *         description="Incluir conteos de cursos",
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
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer"),
     *                     @OA\Property(property="name", type="string"),
     *                     @OA\Property(property="description", type="string"),
     *                     @OA\Property(property="active", type="boolean"),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time"),
     *                     @OA\Property(
     *                         property="courses",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             @OA\Property(property="id", type="integer"),
     *                             @OA\Property(property="name", type="string"),
     *                             @OA\Property(property="description", type="string"),
     *                             @OA\Property(property="cost", type="number"),
     *                             @OA\Property(property="duration", type="integer"),
     *                             @OA\Property(
     *                                 property="modality",
     *                                 type="object",
     *                                 @OA\Property(property="value", type="string"),
     *                                 @OA\Property(property="label", type="string")
     *                             ),
     *                             @OA\Property(property="active", type="boolean")
     *                         )
     *                     ),
     *                     @OA\Property(property="courses_count", type="integer")
     *                 )
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
     *     path="/academies",
     *     operationId="storeAcademy",
     *     tags={"Academies"},
     *     summary="Crear una nueva academia",
     *     description="Almacena una nueva academia en la base de datos",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", example="Academia de Música"),
     *             @OA\Property(property="description", type="string", example="Aprende a tocar instrumentos musicales"),
     *             @OA\Property(property="active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Academia creada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="active", type="boolean"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos no válidos"
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
     *     path="/academies/{id}",
     *     operationId="getAcademy",
     *     tags={"Academies"},
     *     summary="Obtener detalle de una academia",
     *     description="Retorna los datos de una academia específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la academia",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="with_courses",
     *         in="query",
     *         description="Incluir cursos relacionados",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_counts",
     *         in="query",
     *         description="Incluir conteos de cursos",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="active", type="boolean"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(
     *                     property="courses",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer"),
     *                         @OA\Property(property="name", type="string"),
     *                         @OA\Property(property="description", type="string")
     *                     )
     *                 ),
     *                 @OA\Property(property="courses_count", type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Academia no encontrada"
     *     )
     * )
     */
    public static function showEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Put(
     *     path="/academies/{id}",
     *     operationId="updateAcademy",
     *     tags={"Academies"},
     *     summary="Actualizar una academia existente",
     *     description="Actualiza los datos de una academia específica",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la academia",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "description"},
     *             @OA\Property(property="name", type="string", example="Academia de Música Actualizada"),
     *             @OA\Property(property="description", type="string", example="Nueva descripción de la academia"),
     *             @OA\Property(property="active", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Academia actualizada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="active", type="boolean"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Academia no encontrada"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos no válidos"
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
     *     path="/academies/{id}",
     *     operationId="deleteAcademy",
     *     tags={"Academies"},
     *     summary="Eliminar una academia",
     *     description="Elimina una academia específica",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la academia",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Academia eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Academia no encontrada"
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