<?php

namespace Tests\Feature\Api;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Guardian;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test authenticated user can create payment
     */
    public function test_authenticated_user_can_create_payment(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $guardian = Guardian::factory()->create();
        
        $student = new Student([
            'guardian_id' => $guardian->id,
            'first_name' => 'Test',
            'last_name' => 'Student',
            'birth_date' => now()->subYears(10),
            'gender' => 'male'
        ]);
        $student->save();
        
        $course = Course::factory()->create();
        
        $enrollment = Enrollment::factory()->create([
            'student_id' => $student->id,
            'course_id' => $course->id
        ]);

        $paymentData = [
            'enrollment_id' => $enrollment->id,
            'amount' => 250.00,
            'payment_date' => now()->format('Y-m-d H:i:s'),
            'method' => PaymentMethod::CASH->value,
            'status' => PaymentStatus::COMPLETED->value,
            'reference_number' => $this->faker->uuid(),
            'notes' => 'First payment for course enrollment'
        ];

        $response = $this->postJson('/api/v1/payments', $paymentData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id', 'amount', 'payment_date', 'method', 
                    'status', 'reference_number', 'enrollment'
                ]
            ])
            ->assertJsonPath('data.amount', '250.00')
            ->assertJsonPath('data.method.value', PaymentMethod::CASH->value)
            ->assertJsonPath('data.status.value', PaymentStatus::COMPLETED->value);
            
        $this->assertDatabaseHas('payments', [
            'enrollment_id' => $enrollment->id,
            'amount' => 250.00,
            'method' => PaymentMethod::CASH->value,
            'status' => PaymentStatus::COMPLETED->value
        ]);
    }

    /**
     * Test payment validation
     */
    public function test_payment_validation_errors(): void
    {
        Sanctum::actingAs(User::factory()->create());
        
        $paymentData = [
            'amount' => -50.00, // Invalid amount
            'method' => 'invalid_method' // Invalid method
        ];

        $response = $this->postJson('/api/v1/payments', $paymentData);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['enrollment_id', 'amount', 'method']);
    }

    /**
     * Test unauthenticated user cannot create payment
     */
    public function test_unauthenticated_user_cannot_create_payment(): void
    {
        $guardian = Guardian::factory()->create();
        
        $student = new Student([
            'guardian_id' => $guardian->id,
            'first_name' => 'Test',
            'last_name' => 'Student',
            'birth_date' => now()->subYears(10),
            'gender' => 'male'
        ]);
        $student->save();
        
        $course = Course::factory()->create();
        
        $enrollment = Enrollment::factory()->create([
            'student_id' => $student->id,
            'course_id' => $course->id
        ]);

        $paymentData = [
            'enrollment_id' => $enrollment->id,
            'amount' => 250.00,
            'payment_date' => now()->format('Y-m-d H:i:s'),
            'method' => PaymentMethod::BANK_TRANSFER->value,
            'reference_number' => $this->faker->uuid()
        ];

        $response = $this->postJson('/api/v1/payments', $paymentData);

        $response->assertStatus(401);
    }
}
