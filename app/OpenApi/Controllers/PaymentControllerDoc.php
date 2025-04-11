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
            self::storeEndpoint(),
        ];
    }

    /**
     * @OA\Post(
     *     path="/payments",
     *     operationId="storePayment",
     *     tags={"Payments"},
     *     summary="Registrar un nuevo pago",
     *     description="Crea un nuevo registro de pago en el sistema",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"enrollment_id", "amount", "method", "payment_date"},
     *             @OA\Property(property="enrollment_id", type="integer", example=1),
     *             @OA\Property(property="amount", type="number", format="float", example=150.00),
     *             @OA\Property(property="method", type="string", enum={"cash", "bank_transfer"}, example="cash"),
     *             @OA\Property(property="status", type="string", enum={"pending", "completed", "failed", "refunded"}, example="pending"),
     *             @OA\Property(property="payment_date", type="string", format="date", example="2023-07-15"),
     *             @OA\Property(property="reference_number", type="string", example="TRX-123456"),
     *             @OA\Property(property="notes", type="string", example="Pago inicial de matrícula")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pago registrado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Payment"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Los datos proporcionados no son válidos"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="enrollment_id", type="array", @OA\Items(type="string", example="La matrícula es obligatoria")),
     *                 @OA\Property(property="amount", type="array", @OA\Items(type="string", example="El monto del pago es obligatorio")),
     *                 @OA\Property(property="method", type="array", @OA\Items(type="string", example="El método de pago es obligatorio"))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Error al registrar el pago: Mensaje de error")
     *         )
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
} 