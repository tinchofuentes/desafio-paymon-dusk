<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /**
     * Process a payment according to the specified method
     * 
     * @param Payment $payment
     * @return array
     */
    public function processPayment(Payment $payment): array
    {
        Log::info("Procesando pago {$payment->id} por {$payment->amount} con método {$payment->method->value}");
        
        try {
            switch ($payment->method) {
                case PaymentMethod::CASH:
                    return $this->processCashPayment($payment);
                    
                case PaymentMethod::BANK_TRANSFER:
                    return $this->processBankTransferPayment($payment);
                    
                default:
                    throw new \InvalidArgumentException("Método de pago no soportado: {$payment->method->value}");
            }
        } catch (\Exception $e) {
            Log::error("Error procesando pago {$payment->id}: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => "Error procesando pago: " . $e->getMessage()
            ];
        }
    }
    
    /**
     * Process a cash payment
     * 
     * @param Payment $payment
     * @return array
     */
    protected function processCashPayment(Payment $payment): array
    {
        sleep(1); // Simulamos tiempo de procesamiento
        
        $payment->status = PaymentStatus::COMPLETED;
        $payment->save();
        
        return [
            'success' => true,
            'message' => 'Pago en efectivo procesado correctamente',
            'transaction_id' => 'CASH-' . time() . '-' . $payment->id
        ];
    }
    
    /**
     * Process a bank transfer payment
     * 
     * @param Payment $payment
     * @return array
     */
    protected function processBankTransferPayment(Payment $payment): array
    {
        if (empty($payment->reference_number)) {
            throw new \InvalidArgumentException('Para transferencias bancarias se requiere un número de referencia');
        }
        
        sleep(1); // Simulamos tiempo de procesamiento
        
        if (!preg_match('/^[A-Z0-9]{5,15}$/', $payment->reference_number)) {
            return [
                'success' => false,
                'message' => 'Número de referencia inválido'
            ];
        }
        
        $payment->status = PaymentStatus::COMPLETED;
        $payment->save();
        
        return [
            'success' => true,
            'message' => 'Transferencia bancaria validada correctamente',
            'transaction_id' => 'BANK-' . time() . '-' . $payment->id
        ];
    }
} 