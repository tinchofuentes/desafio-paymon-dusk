<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Payment",
 *     required={"id", "amount", "method", "status", "payment_date"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="enrollment_id",
 *         type="integer",
 *         format="int64",
 *         example=123
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="number",
 *         format="float",
 *         example=1500.00
 *     ),
 *     @OA\Property(
 *         property="method",
 *         type="object",
 *         @OA\Property(
 *             property="value",
 *             type="string",
 *             enum={"cash", "bank_transfer"},
 *             example="cash"
 *         ),
 *         @OA\Property(
 *             property="label",
 *             type="string",
 *             example="Efectivo"
 *         )
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="object",
 *         @OA\Property(
 *             property="value",
 *             type="string",
 *             enum={"pending", "completed", "failed", "refunded"},
 *             example="completed"
 *         ),
 *         @OA\Property(
 *             property="label",
 *             type="string",
 *             example="Completado"
 *         )
 *     ),
 *     @OA\Property(
 *         property="payment_date",
 *         type="string",
 *         format="date",
 *         example="2023-07-15"
 *     ),
 *     @OA\Property(
 *         property="reference_number",
 *         type="string",
 *         example="REF123456"
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="string",
 *         example="Pago del primer mes"
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
 *     )
 * )
 */
class PaymentSchema
{
    // Esta clase solo se utiliza para la documentación de OpenAPI
} 