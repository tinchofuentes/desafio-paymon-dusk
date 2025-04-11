<?php

namespace App\OpenApi\Controllers;

use App\OpenApi\ApiDocumentation;

/**
 * @OA\Tag(
 *     name="Payments",
 *     description="API Endpoints de gestión de pagos"
 * )
 */
class PaymentControllerDoc implements ApiDocumentation
{
    /**
     * Get all OpenAPI annotations for the PaymentController
     */
    public static function getAnnotations(): array
    {
        return [
            self::processEndpoint(),
        ];
    }

    /**
     * @OA\Post(
     *     path="/payments/{payment}/process",
     *     operationId="processPayment",
     *     tags={"Payments"},
     *     summary="Procesar un pago existente",
     *     description="Procesa un pago según su método (efectivo o transferencia bancaria)",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="payment",
     *         in="path",
     *         description="ID del pago a procesar",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Pago procesado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Pago en efectivo procesado correctamente"),
     *             @OA\Property(property="transaction_id", type="string", example="CASH-1625145600-123"),
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Payment"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error en el procesamiento del pago",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Número de referencia inválido")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Pago no encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error al procesar el pago: Mensaje de error")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public static function processEndpoint(): string
    {
        return "";
    }
} 