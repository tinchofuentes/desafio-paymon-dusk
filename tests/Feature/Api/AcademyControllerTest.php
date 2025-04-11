<?php

namespace Tests\Feature\Api;

use App\Models\Academy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AcademyControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /**
     * Test get all academies (public endpoint)
     */
    public function test_can_get_all_academies(): void
    {
        Academy::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/academies');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'description', 'logo', 'active']
                ],
                'links',
                'meta'
            ]);
    }

    /**
     * Test get academy with filter
     */
    public function test_can_get_academies_with_active_filter(): void
    {
        Academy::factory()->count(2)->create(['active' => true]);
        Academy::factory()->count(2)->create(['active' => false]);

        $response = $this->getJson('/api/v1/academies?active=true');

        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.active', true)
            ->assertJsonPath('data.1.active', true);
    }

    /**
     * Test get single academy
     */
    public function test_can_get_single_academy(): void
    {
        $academy = Academy::factory()->create();

        $response = $this->getJson("/api/v1/academies/{$academy->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'description', 'logo', 'active']
            ])
            ->assertJsonPath('data.id', $academy->id)
            ->assertJsonPath('data.name', $academy->name);
    }

    /**
     * Test create academy
     */
    public function test_authenticated_user_can_create_academy(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $academyData = [
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'logo' => $this->faker->imageUrl(),
            'active' => true
        ];

        $response = $this->postJson('/api/v1/academies', $academyData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'name', 'description', 'logo', 'active']
            ])
            ->assertJsonPath('data.name', $academyData['name'])
            ->assertJsonPath('data.description', $academyData['description']);
    }

    /**
     * Test update academy
     */
    public function test_authenticated_user_can_update_academy(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $academy = Academy::factory()->create();

        $updateData = [
            'name' => 'Updated Academy Name',
            'description' => 'Updated description',
            'active' => false
        ];

        $response = $this->putJson("/api/v1/academies/{$academy->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'Updated Academy Name')
            ->assertJsonPath('data.description', 'Updated description')
            ->assertJsonPath('data.active', false);
    }

    /**
     * Test delete academy
     */
    public function test_authenticated_user_can_delete_academy(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $academy = Academy::factory()->create();

        $response = $this->deleteJson("/api/v1/academies/{$academy->id}");

        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('academies', ['id' => $academy->id]);
    }

    /**
     * Test unauthenticated user cannot create academy
     */
    public function test_unauthenticated_user_cannot_create_academy(): void
    {
        $academyData = [
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'active' => true
        ];

        $response = $this->postJson('/api/v1/academies', $academyData);

        $response->assertStatus(401);
    }
}
