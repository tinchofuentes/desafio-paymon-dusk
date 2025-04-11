<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentProcessRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use App\OpenApi\Controllers\PaymentControllerDoc;
use Illuminate\Http\JsonResponse;

/**
 * @see PaymentControllerDoc for API documentation
 */
class PaymentController extends Controller
{
    protected $paymentService;
    
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    
    public function process(PaymentProcessRequest $request, Payment $payment): JsonResponse
    {
        try {
            $result = $this->paymentService->processPayment($payment);
            
            if ($result['success']) {
                $payment->refresh();
                
                return response()->json([
                    'message' => $result['message'],
                    'transaction_id' => $result['transaction_id'] ?? null,
                    'data' => new PaymentResource($payment)
                ]);
            } else {
                return response()->json([
                    'message' => $result['message']
                ], 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al procesar el pago: ' . $e->getMessage()
            ], 500);
        }
    }
}
