<?php

namespace Tests\Feature\Api;

use App\Enums\CommunicationStatus;
use App\Models\Communication;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CommunicationControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * Test authenticated user can get all communications
     */
    public function test_authenticated_user_can_get_all_communications(): void
    {
        Sanctum::actingAs(User::factory()->create());
        
        Communication::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/communications');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'title', 'message', 'send_date', 
                        'status', 'age_from', 'age_to'
                    ]
                ],
                'links',
                'meta'
            ]);
    }

    /**
     * Test authenticated user can get single communication
     */
    public function test_authenticated_user_can_get_single_communication(): void
    {
        Sanctum::actingAs(User::factory()->create());
        
        $communication = Communication::factory()->create();

        $response = $this->getJson("/api/v1/communications/{$communication->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id', 'title', 'message', 'send_date', 
                    'status', 'age_from', 'age_to'
                ]
            ])
            ->assertJsonPath('data.id', $communication->id)
            ->assertJsonPath('data.title', $communication->title);
    }

    /**
     * Test authenticated user can create communication
     */
    public function test_authenticated_user_can_create_communication(): void
    {
        Sanctum::actingAs(User::factory()->create());
        
        $course = Course::factory()->create();

        $communicationData = [
            'course_id' => $course->id,
            'title' => 'Important Announcement',
            'message' => 'This is an important message for all students and parents.',
            'send_date' => now()->addDays(2)->format('Y-m-d H:i:s'),
            'status' => CommunicationStatus::DRAFT->value,
            'age_from' => 10,
            'age_to' => 15
        ];

        $response = $this->postJson('/api/v1/communications', $communicationData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id', 'title', 'message', 'send_date', 
                    'status', 'age_from', 'age_to'
                ]
            ])
            ->assertJsonPath('data.title', 'Important Announcement')
            ->assertJsonPath('data.status.value', CommunicationStatus::DRAFT->value);
    }

    /**
     * Test authenticated user can update communication
     */
    public function test_authenticated_user_can_update_communication(): void
    {
        Sanctum::actingAs(User::factory()->create());
        
        $communication = Communication::factory()->create([
            'status' => CommunicationStatus::DRAFT
        ]);

        $updateData = [
            'title' => 'Updated Announcement',
            'message' => 'This is the updated content of the communication.',
            'status' => CommunicationStatus::SCHEDULED->value
        ];

        $response = $this->putJson("/api/v1/communications/{$communication->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.title', 'Updated Announcement')
            ->assertJsonPath('data.message', 'This is the updated content of the communication.')
            ->assertJsonPath('data.status.value', CommunicationStatus::SCHEDULED->value);
    }

    /**
     * Test authenticated user can delete communication
     */
    public function test_authenticated_user_can_delete_communication(): void
    {
        Sanctum::actingAs(User::factory()->create());
        
        $communication = Communication::factory()->create();

        $response = $this->deleteJson("/api/v1/communications/{$communication->id}");

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('communications', ['id' => $communication->id]);
    }

    /**
     * Test authenticated user can send communication
     */
    public function test_authenticated_user_can_send_communication(): void
    {
        Sanctum::actingAs(User::factory()->create());
        
        $course = Course::factory()->create();
        
        $guardian = \App\Models\Guardian::factory()->create();
        
        $student = new \App\Models\Student([
            'guardian_id' => $guardian->id,
            'first_name' => 'Test',
            'last_name' => 'Student',
            'birth_date' => now()->subYears(12),
            'gender' => 'male'
        ]);
        $student->save();
        
        \App\Models\Enrollment::factory()->create([
            'student_id' => $student->id,
            'course_id' => $course->id
        ]);
        
        $communication = Communication::factory()->create([
            'status' => CommunicationStatus::SCHEDULED,
            'course_id' => $course->id,
            'age_from' => 10,
            'age_to' => 15
        ]);

        $response = $this->postJson("/api/v1/communications/{$communication->id}/send");

        $response->assertStatus(200)
            ->assertJsonStructure(['message', 'total', 'sent', 'errors']);
    }

    /**
     * Test unauthenticated user cannot access communications
     */
    public function test_unauthenticated_user_cannot_access_communications(): void
    {
        Communication::factory()->create();

        $response = $this->getJson('/api/v1/communications');

        $response->assertStatus(401);
    }
}
