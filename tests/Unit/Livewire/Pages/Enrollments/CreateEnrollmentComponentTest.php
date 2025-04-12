<?php

namespace Tests\Unit\Livewire\Pages\Enrollments;

use App\Enums\EnrollmentStatus;
use App\Enums\Gender;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Livewire\Pages\Enrollments\CreateEnrollmentComponent;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Guardian;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateEnrollmentComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the component can be rendered.
     */
    public function test_component_can_render(): void
    {
        Livewire::test(CreateEnrollmentComponent::class)
            ->assertStatus(200);
    }

    /**
     * Test that the component initializes with a course when provided.
     */
    public function test_component_initializes_with_course(): void
    {
        $course = Course::factory()->create([
            'cost' => 299.99
        ]);

        Livewire::test(CreateEnrollmentComponent::class, ['course' => $course->id])
            ->assertSet('course_id', $course->id)
            ->assertSet('course_cost', 299.99);
    }

    /**
     * Test that moving between steps validates the data correctly.
     */
    public function test_component_validates_steps(): void
    {
        Livewire::test(CreateEnrollmentComponent::class)

            ->call('nextStep')
            ->assertHasErrors(['guardian_name', 'guardian_email', 'guardian_phone'])

            ->set('guardian_name', 'John Doe')
            ->set('guardian_email', 'john@example.com')
            ->set('guardian_phone', '123456789')
            ->call('nextStep')

            ->assertSet('currentStep', 2)

            ->call('nextStep')
            ->assertHasErrors(['student_first_name', 'student_last_name', 'course_id'])

            ->call('previousStep')
            ->assertSet('currentStep', 1);
    }

    /**
     * Test moving from step 2 to step 3 with valid data.
     */
    public function test_component_moves_to_step_3_with_valid_data(): void
    {
        $course = Course::factory()->create();

        Livewire::test(CreateEnrollmentComponent::class)

            ->set('guardian_name', 'John Doe')
            ->set('guardian_email', 'john@example.com')
            ->set('guardian_phone', '123456789')
            ->call('nextStep')

            ->set('student_first_name', 'Jane')
            ->set('student_last_name', 'Doe')
            ->set('student_birth_date', now()->subYears(10)->format('Y-m-d'))
            ->set('student_gender', Gender::FEMALE->value)
            ->set('course_id', $course->id)
            ->call('nextStep')

            ->assertSet('currentStep', 3);
    }

    /**
     * Test validation of payment method in the final step.
     */
    public function test_component_validates_payment_method(): void
    {
        $course = Course::factory()->create();

        Livewire::test(CreateEnrollmentComponent::class)

            ->set('guardian_name', 'John Doe')
            ->set('guardian_email', 'john@example.com')
            ->set('guardian_phone', '123456789')
            ->call('nextStep')

            ->set('student_first_name', 'Jane')
            ->set('student_last_name', 'Doe')
            ->set('student_birth_date', now()->subYears(10)->format('Y-m-d'))
            ->set('student_gender', Gender::FEMALE->value)
            ->set('course_id', $course->id)
            ->call('nextStep')

            ->call('submit')
            ->assertHasErrors(['payment_method'])

            ->set('payment_method', PaymentMethod::CASH->value)
            ->assertHasNoErrors(['payment_method']);
    }

    /**
     * Test validation of reference number for bank transfer payments.
     */
    public function test_component_validates_reference_number_for_bank_transfers(): void
    {
        $course = Course::factory()->create();

        Livewire::test(CreateEnrollmentComponent::class)

            ->set('guardian_name', 'John Doe')
            ->set('guardian_email', 'john@example.com')
            ->set('guardian_phone', '123456789')
            ->call('nextStep')

            ->set('student_first_name', 'Jane')
            ->set('student_last_name', 'Doe')
            ->set('student_birth_date', now()->subYears(10)->format('Y-m-d'))
            ->set('student_gender', Gender::FEMALE->value)
            ->set('course_id', $course->id)
            ->call('nextStep')

            ->set('payment_method', PaymentMethod::BANK_TRANSFER->value)
            ->call('submit')
            ->assertHasErrors(['reference_number'])

            ->set('reference_number', 'REF12345')
            ->assertHasNoErrors(['reference_number']);
    }

    /**
     * Test the full enrollment process creates proper records in the database.
     */
    public function test_component_creates_enrollment_and_payment(): void
    {
        $course = Course::factory()->create([
            'cost' => 200.00
        ]);

        Livewire::test(CreateEnrollmentComponent::class)

            ->set('guardian_name', 'John Doe')
            ->set('guardian_email', 'john@example.com')
            ->set('guardian_phone', '123456789')
            ->call('nextStep')

            ->set('student_first_name', 'Jane')
            ->set('student_last_name', 'Doe')
            ->set('student_birth_date', now()->subYears(10)->format('Y-m-d'))
            ->set('student_gender', Gender::FEMALE->value)
            ->set('course_id', $course->id)
            ->call('nextStep')

            ->set('payment_method', PaymentMethod::CASH->value)
            ->call('submit');

        $this->assertDatabaseHas('guardians', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789'
        ]);

        $guardian = Guardian::where('email', 'john@example.com')->first();

        $this->assertDatabaseHas('students', [
            'guardian_id' => $guardian->id,
            'first_name' => 'Jane',
            'last_name' => 'Doe'
        ]);

        $student = Student::where('guardian_id', $guardian->id)->first();

        $this->assertDatabaseHas('enrollments', [
            'student_id' => $student->id,
            'course_id' => $course->id,
            'status' => EnrollmentStatus::PENDING->value
        ]);

        $enrollment = Enrollment::where('student_id', $student->id)->first();

        $this->assertDatabaseHas('payments', [
            'enrollment_id' => $enrollment->id,
            'amount' => 200.00,
            'method' => PaymentMethod::CASH->value,
            'status' => PaymentStatus::PENDING->value
        ]);
    }
} 