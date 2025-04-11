<?php

namespace App\OpenApi\Controllers;

use App\OpenApi\ApiDocumentation;

/**
 * @OA\Tag(
 *     name="Communications",
 *     description="API Endpoints de gestión de comunicados a tutores"
 * )
 */
class CommunicationControllerDoc implements ApiDocumentation
{
    /**
     * Get all OpenAPI annotations for the CommunicationController
     */
    public static function getAnnotations(): array
    {
        return [
            self::indexEndpoint(),
            self::storeEndpoint(),
            self::showEndpoint(),
            self::updateEndpoint(),
            self::destroyEndpoint(),
            self::sendEndpoint(),
        ];
    }

    /**
     * @OA\Get(
     *     path="/communications",
     *     operationId="getCommunicationsList",
     *     tags={"Communications"},
     *     summary="Obtener listado de comunicados",
     *     description="Retorna un listado paginado de comunicados",
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
     *         description="Filtrar por estado del comunicado",
     *         required=false,
     *         @OA\Schema(type="string", enum={"draft", "sent", "scheduled"})
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
     *         name="search",
     *         in="query",
     *         description="Buscar por título o mensaje",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="with_course",
     *         in="query",
     *         description="Incluir curso relacionado",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_guardians",
     *         in="query",
     *         description="Incluir tutores relacionados",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_counts",
     *         in="query",
     *         description="Incluir conteos de tutores",
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
     *                 @OA\Items(ref="#/components/schemas/Communication")
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
     *     path="/communications",
     *     operationId="storeCommunication",
     *     tags={"Communications"},
     *     summary="Crear un nuevo comunicado",
     *     description="Crea un nuevo comunicado en la base de datos",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"course_id", "title", "message", "send_date"},
     *             @OA\Property(property="course_id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Reunión de padres"),
     *             @OA\Property(property="message", type="string", example="Se convoca a todos los padres a una reunión el próximo martes"),
     *             @OA\Property(property="send_date", type="string", format="date-time", example="2023-05-15T18:00:00"),
     *             @OA\Property(property="status", type="string", enum={"draft", "sent", "scheduled"}, example="scheduled"),
     *             @OA\Property(property="send_now", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comunicado creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Communication"
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
     *     path="/communications/{id}",
     *     operationId="getCommunication",
     *     tags={"Communications"},
     *     summary="Obtener detalle de un comunicado",
     *     description="Retorna los datos de un comunicado específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del comunicado",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="with_course",
     *         in="query",
     *         description="Incluir curso relacionado",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_guardians",
     *         in="query",
     *         description="Incluir tutores relacionados",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Parameter(
     *         name="with_counts",
     *         in="query",
     *         description="Incluir conteos de tutores",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Communication"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comunicado no encontrado"
     *     )
     * )
     */
    public static function showEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Put(
     *     path="/communications/{id}",
     *     operationId="updateCommunication",
     *     tags={"Communications"},
     *     summary="Actualizar un comunicado existente",
     *     description="Actualiza los datos de un comunicado específico",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del comunicado",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="course_id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Reunión de padres (actualizado)"),
     *             @OA\Property(property="message", type="string", example="Se ha modificado la fecha de la reunión"),
     *             @OA\Property(property="send_date", type="string", format="date-time", example="2023-05-16T18:00:00"),
     *             @OA\Property(property="status", type="string", enum={"draft", "sent", "scheduled"}, example="scheduled")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comunicado actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Communication"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comunicado no encontrado"
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
     *     path="/communications/{id}",
     *     operationId="deleteCommunication",
     *     tags={"Communications"},
     *     summary="Eliminar un comunicado",
     *     description="Elimina un comunicado específico",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del comunicado",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Comunicado eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comunicado no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public static function destroyEndpoint(): string
    {
        return "";
    }

    /**
     * @OA\Post(
     *     path="/communications/{id}/send",
     *     operationId="sendCommunication",
     *     tags={"Communications"},
     *     summary="Enviar un comunicado a los destinatarios",
     *     description="Envía un comunicado existente a todos los tutores asociados con el curso",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del comunicado",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comunicado enviado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Comunicado enviado a 12 destinatarios"),
     *             @OA\Property(property="sent", type="integer", example=12),
     *             @OA\Property(property="errors", type="integer", example=0)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Comunicado no encontrado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="El comunicado ya ha sido enviado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public static function sendEndpoint(): string
    {
        return "";
    }
} 