<?php

namespace App\OpenApi\Parameters;

/**
 * @OA\Parameter(
 *     parameter="id_in_path",
 *     name="id",
 *     in="path",
 *     description="ID del recurso",
 *     required=true,
 *     @OA\Schema(type="integer")
 * )
 * 
 * @OA\Parameter(
 *     parameter="course_id_query",
 *     name="course_id",
 *     in="query",
 *     description="Filtrar por curso",
 *     required=false,
 *     @OA\Schema(type="integer")
 * )
 * 
 * @OA\Parameter(
 *     parameter="with_course_query",
 *     name="with_course",
 *     in="query",
 *     description="Incluir curso relacionado",
 *     required=false,
 *     @OA\Schema(type="boolean")
 * )
 * 
 * @OA\Parameter(
 *     parameter="with_counts_query",
 *     name="with_counts",
 *     in="query",
 *     description="Incluir conteos de relaciones",
 *     required=false,
 *     @OA\Schema(type="boolean")
 * )
 * 
 * @OA\Parameter(
 *     parameter="active_query",
 *     name="active",
 *     in="query",
 *     description="Filtrar por estado activo/inactivo",
 *     required=false,
 *     @OA\Schema(type="boolean")
 * )
 * 
 * @OA\Parameter(
 *     parameter="per_page_query",
 *     name="per_page",
 *     in="query",
 *     description="Número de resultados por página",
 *     required=false,
 *     @OA\Schema(type="integer", default=15)
 * )
 * 
 * @OA\Parameter(
 *     parameter="from_date_query",
 *     name="from_date",
 *     in="query",
 *     description="Filtrar desde fecha (formato Y-m-d)",
 *     required=false,
 *     @OA\Schema(type="string", format="date")
 * )
 * 
 * @OA\Parameter(
 *     parameter="to_date_query",
 *     name="to_date",
 *     in="query",
 *     description="Filtrar hasta fecha (formato Y-m-d)",
 *     required=false,
 *     @OA\Schema(type="string", format="date")
 * )
 */
class CommonParameters
{
    // Esta clase es solo para documentación OpenAPI
} 