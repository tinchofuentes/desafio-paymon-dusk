<?php

namespace Tests\Unit\Models;

use App\Models\Guardian;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuardianTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a guardian belongs to a user
     */
    public function test_guardian_belongs_to_user()
    {
        $guardian = Guardian::factory()->create();
        $this->assertInstanceOf(User::class, $guardian->user);
    }

    /**
     * Test that a guardian has many students
     */
    public function test_guardian_has_many_students()
    {
        $guardian = Guardian::factory()->create();
        $students = Student::factory()
            ->count(3)
            ->create(['guardian_id' => $guardian->id]);
        
        $this->assertCount(3, $guardian->students);
        $this->assertInstanceOf(Student::class, $guardian->students->first());
    }

    /**
     * Test that a guardian can be created through a factory
     */
    public function test_guardian_can_be_created_through_factory()
    {
        $guardian = Guardian::factory()->create();
        
        $this->assertNotNull($guardian->id);
        $this->assertNotNull($guardian->name);
        $this->assertNotNull($guardian->email);
        $this->assertNotNull($guardian->phone);
    }

    /**
     * Test that a guardian can be created with minimum required fields
     */
    public function test_guardian_can_be_created_with_minimum_fields()
    {
        $guardian = Guardian::factory()->create([
            'phone' => null,
            'user_id' => null
        ]);
        
        $this->assertNotNull($guardian->id);
        $this->assertNotNull($guardian->name);
        $this->assertNotNull($guardian->email);
        $this->assertNull($guardian->phone);
        $this->assertNull($guardian->user_id);
    }
} 