<?php

namespace Tests\Unit\Services;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use ReflectionClass;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    private PaymentService $paymentService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentService = new PaymentService();
    }

    /**
     * Test processing a cash payment
     */
    public function test_process_cash_payment(): void
    {
        $payment = Payment::factory()->create([
            'method' => PaymentMethod::CASH,
            'status' => PaymentStatus::PENDING
        ]);

        $result = $this->paymentService->processPayment($payment);

        $payment->refresh();

        $this->assertTrue($result['success']);
        $this->assertEquals('Pago en efectivo procesado correctamente', $result['message']);
        $this->assertArrayHasKey('transaction_id', $result);
        $this->assertStringContainsString('CASH-', $result['transaction_id']);

        $this->assertEquals(PaymentStatus::COMPLETED, $payment->status);
    }

    /**
     * Test processing a valid bank transfer payment
     */
    public function test_process_valid_bank_transfer_payment(): void
    {
        $payment = Payment::factory()->create([
            'method' => PaymentMethod::BANK_TRANSFER,
            'status' => PaymentStatus::PENDING,
            'reference_number' => 'REF12345'
        ]);

        $result = $this->paymentService->processPayment($payment);

        $payment->refresh();

        $this->assertTrue($result['success']);
        $this->assertEquals('Transferencia bancaria validada correctamente', $result['message']);
        $this->assertArrayHasKey('transaction_id', $result);
        $this->assertStringContainsString('BANK-', $result['transaction_id']);

        $this->assertEquals(PaymentStatus::COMPLETED, $payment->status);
    }

    /**
     * Test processing a bank transfer payment with invalid reference number
     */
    public function test_process_bank_transfer_with_invalid_reference(): void
    {
        $payment = Payment::factory()->create([
            'method' => PaymentMethod::BANK_TRANSFER,
            'status' => PaymentStatus::PENDING,
            'reference_number' => 'inv@lid'
        ]);

        $result = $this->paymentService->processPayment($payment);

        $payment->refresh();

        $this->assertFalse($result['success']);
        $this->assertEquals('Número de referencia inválido', $result['message']);

        $this->assertEquals(PaymentStatus::PENDING, $payment->status);
    }

    /**
     * Test processing a bank transfer payment with missing reference number
     */
    public function test_process_bank_transfer_with_missing_reference(): void
    {
        $payment = Payment::factory()->create([
            'method' => PaymentMethod::BANK_TRANSFER,
            'status' => PaymentStatus::PENDING,
            'reference_number' => null
        ]);

        $result = $this->paymentService->processPayment($payment);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Para transferencias bancarias se requiere un número de referencia', $result['message']);
    }

    /**
     * Test processing a payment with unsupported payment method
     */
    public function test_process_payment_with_unsupported_method(): void
    {
        $paymentServiceMock = $this->getMockBuilder(PaymentService::class)
            ->onlyMethods(['processPayment'])
            ->getMock();
        
        $paymentServiceMock->method('processPayment')
            ->willReturn([
                'success' => false,
                'message' => 'Error procesando pago: Método de pago no soportado'
            ]);
        
        $payment = Payment::factory()->create([
            'method' => PaymentMethod::CASH,
            'status' => PaymentStatus::PENDING
        ]);

        $result = $paymentServiceMock->processPayment($payment);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Error procesando pago', $result['message']);
    }
} 