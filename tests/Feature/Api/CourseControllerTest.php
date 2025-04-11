<?php

namespace Tests\Feature\Api;

use App\Enums\CourseModality;
use App\Models\Academy;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test getting all courses (public endpoint)
     */
    public function test_can_get_all_courses(): void
    {
        Course::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/courses?with_academy=true');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'name', 'description', 'cost', 'duration', 
                        'modality', 'active', 'capacity', 'start_date', 'end_date',
                        'academy'
                    ]
                ],
                'links',
                'meta'
            ]);
    }

    /**
     * Test getting courses with active filter
     */
    public function test_can_get_courses_with_active_filter(): void
    {
        Course::factory()->count(2)->create(['active' => true]);
        Course::factory()->count(2)->create(['active' => false]);

        $response = $this->getJson('/api/v1/courses?active=true');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.active', true)
            ->assertJsonPath('data.1.active', true);
    }

    /**
     * Test getting a single course
     */
    public function test_can_get_single_course(): void
    {
        $course = Course::factory()->create();

        $response = $this->getJson("/api/v1/courses/{$course->id}?with_academy=true");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id', 'name', 'description', 'cost', 'duration', 
                    'modality', 'active', 'capacity', 'start_date', 'end_date',
                    'academy'
                ]
            ])
            ->assertJsonPath('data.id', $course->id)
            ->assertJsonPath('data.name', $course->name);
    }

    /**
     * Test authenticated user can create course
     */
    public function test_authenticated_user_can_create_course(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $academy = Academy::factory()->create();

        $startDate = now()->addDays(10);
        $endDate = now()->addMonths(3);
        
        $courseData = [
            'academy_id' => $academy->id,
            'name' => 'New Test Course',
            'description' => 'Course description',
            'cost' => 199.99,
            'duration' => 40,
            'modality' => CourseModality::IN_PERSON->value,
            'active' => true,
            'capacity' => 25,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];

        $response = $this->postJson('/api/v1/courses', $courseData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id', 'name', 'description', 'cost', 'duration', 
                    'modality', 'active', 'capacity', 'start_date', 'end_date'
                ]
            ])
            ->assertJsonPath('data.name', 'New Test Course')
            ->assertJsonPath('data.cost', '199.99')
            ->assertJsonPath('data.modality.value', CourseModality::IN_PERSON->value);
    }

    /**
     * Test authenticated user can update course
     */
    public function test_authenticated_user_can_update_course(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $course = Course::factory()->create();

        $updateData = [
            'academy_id' => $course->academy_id,
            'name' => 'Updated Course Name',
            'description' => 'Updated description',
            'cost' => 249.99,
            'duration' => 60,
            'modality' => CourseModality::ONLINE->value,
        ];

        $response = $this->putJson("/api/v1/courses/{$course->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Updated Course Name')
            ->assertJsonPath('data.description', 'Updated description')
            ->assertJsonPath('data.cost', '249.99')
            ->assertJsonPath('data.modality.value', CourseModality::ONLINE->value);
    }

    /**
     * Test authenticated user can delete course
     */
    public function test_authenticated_user_can_delete_course(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $course = Course::factory()->create();

        $response = $this->deleteJson("/api/v1/courses/{$course->id}");

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    /**
     * Test unauthenticated user cannot create course
     */
    public function test_unauthenticated_user_cannot_create_course(): void
    {
        $academy = Academy::factory()->create();

        $courseData = [
            'academy_id' => $academy->id,
            'name' => 'New Test Course',
            'description' => 'Course description',
            'cost' => 199.99,
        ];

        $response = $this->postJson('/api/v1/courses', $courseData);

        $response->assertStatus(401);
    }
}
