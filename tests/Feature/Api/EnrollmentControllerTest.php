<?php

namespace Tests\Feature\Api;

use App\Enums\EnrollmentStatus;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EnrollmentControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test public user can create enrollment 
     */
    public function test_can_create_enrollment(): void
    {
        $course = Course::factory()->create(['active' => true]);
        
        $enrollmentData = [
            'course_id' => $course->id,
            'guardian_name' => 'Test Guardian',
            'guardian_email' => 'guardian@example.com',
            'guardian_phone' => '123456789',
            'student_first_name' => 'Test',
            'student_last_name' => 'Student',
            'student_birth_date' => '2010-05-15',
            'student_gender' => 'male',
            'payment_method' => 'cash',
            'payment_amount' => 100.00
        ];

        $response = $this->postJson('/api/v1/enrollments', $enrollmentData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id', 
                    'enrollment_date', 
                    'status',
                    'student' => ['id', 'first_name', 'last_name', 'birth_date', 'gender'],
                    'course' => ['id', 'name', 'cost', 'modality'],
                ]
            ]);
            
        $this->assertDatabaseHas('students', [
            'first_name' => 'Test',
            'last_name' => 'Student'
        ]);
        
        $this->assertDatabaseHas('enrollments', [
            'course_id' => $course->id,
            'status' => EnrollmentStatus::PENDING->value
        ]);
    }

    /**
     * Test authenticated user can get all enrollments
     */
    public function test_authenticated_user_can_get_all_enrollments(): void
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
        
        Enrollment::factory()->count(3)->create([
            'student_id' => $student->id,
            'course_id' => $course->id
        ]);

        $response = $this->getJson('/api/v1/enrollments?with_student=true&with_course=true');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 
                        'enrollment_date', 
                        'status',
                        'student',
                        'course',
                    ]
                ],
                'links',
                'meta'
            ]);
    }

    /**
     * Test authenticated user can get single enrollment
     */
    public function test_authenticated_user_can_get_single_enrollment(): void
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

        $response = $this->getJson("/api/v1/enrollments/{$enrollment->id}?with_student=true&with_course=true");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id', 
                    'enrollment_date', 
                    'status',
                    'student',
                    'course',
                ]
            ])
            ->assertJsonPath('data.id', $enrollment->id);
    }

    /**
     * Test authenticated user can update enrollment
     */
    public function test_authenticated_user_can_update_enrollment(): void
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
            'course_id' => $course->id,
            'status' => EnrollmentStatus::PENDING
        ]);
        
        $enrollment->status = EnrollmentStatus::CONFIRMED;
        $enrollment->notes = 'Enrollment confirmed after payment validation';
        $enrollment->save();
        
        $this->assertDatabaseHas('enrollments', [
            'id' => $enrollment->id,
            'status' => EnrollmentStatus::CONFIRMED->value,
            'notes' => 'Enrollment confirmed after payment validation'
        ]);
        
        $response = $this->getJson("/api/v1/enrollments/{$enrollment->id}?with_student=true&with_course=true");
        
        $response->assertStatus(200)
            ->assertJsonPath('data.status.value', EnrollmentStatus::CONFIRMED->value);
    }

    /**
     * Test authenticated user can delete enrollment
     */
    public function test_authenticated_user_can_delete_enrollment(): void
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

        $response = $this->deleteJson("/api/v1/enrollments/{$enrollment->id}");

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('enrollments', ['id' => $enrollment->id]);
    }

    /**
     * Test unauthenticated user cannot get enrollments
     */
    public function test_unauthenticated_user_cannot_get_enrollments(): void
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
        
        Enrollment::factory()->count(3)->create([
            'student_id' => $student->id,
            'course_id' => $course->id
        ]);

        $response = $this->getJson('/api/v1/enrollments');

        $response->assertStatus(401);
    }
}
