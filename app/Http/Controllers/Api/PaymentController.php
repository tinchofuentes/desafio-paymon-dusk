<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\OpenApi\Controllers\PaymentControllerDoc;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * @see PaymentControllerDoc for API documentation
 */
class PaymentController extends Controller
{
    /**
     * Registrar un nuevo pago
     *
     * @param PaymentRequest $request
     * @return JsonResponse
     */
    public function store(PaymentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            
            $validated = $request->validated();
            
            $payment = Payment::create([
                'enrollment_id' => $validated['enrollment_id'],
                'amount' => $validated['amount'],
                'method' => $validated['method'],
                'status' => $validated['status'] ?? PaymentStatus::PENDING,
                'payment_date' => $validated['payment_date'],
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);
            
            DB::commit();
            
            // Cargar la relación enrollment
            $payment->load('enrollment');
            
            return (new PaymentResource($payment))
                ->response()
                ->setStatusCode(201);
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'message' => 'Error al registrar el pago: ' . $e->getMessage()
            ], 500);
        }
    }
}
