<?php

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\GuardianResource;
use App\Http\Resources\StudentResource;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuardianResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test basic guardian resource transformation
     */
    public function test_guardian_resource_basic_transformation()
    {
        $guardian = Guardian::factory()->create();
        
        $resource = (new GuardianResource($guardian))->toArray(request());
        
        $this->assertEquals($guardian->id, $resource['id']);
        $this->assertEquals($guardian->name, $resource['name']);
        $this->assertEquals($guardian->email, $resource['email']);
        $this->assertEquals($guardian->phone, $resource['phone']);
        $this->assertEquals($guardian->created_at, $resource['created_at']);
        $this->assertEquals($guardian->updated_at, $resource['updated_at']);
    }

    /**
     * Test guardian resource with loaded students
     */
    public function test_guardian_resource_with_loaded_students()
    {
        $guardian = Guardian::factory()->create();
        $students = Student::factory()
            ->count(3)
            ->create(['guardian_id' => $guardian->id]);
        
        $guardian->load('students');
        $guardian->loadCount('students');
        
        $resource = (new GuardianResource($guardian))->toArray(request());
        
        $this->assertArrayHasKey('students', $resource);
        $this->assertCount(3, $resource['students']);
        $this->assertEquals(3, $resource['students_count']);
        
        // Verify students are properly transformed
        foreach ($resource['students'] as $index => $studentData) {
            $this->assertArrayHasKey('id', $studentData);
            $this->assertEquals($students[$index]->id, $studentData['id']);
        }
    }

    /**
     * Test guardian resource with loaded students but no count
     */
    public function test_guardian_resource_with_loaded_students_but_no_count()
    {
        $guardian = Guardian::factory()->create();
        Student::factory()
            ->count(3)
            ->create(['guardian_id' => $guardian->id]);
        
        $guardian->load('students');
        
        $resource = (new GuardianResource($guardian))->toArray(request());
        
        $this->assertArrayHasKey('students', $resource);
        $this->assertNotEmpty($resource['students']);
        $this->assertArrayHasKey('students_count', $resource);
        $this->assertInstanceOf(\Illuminate\Http\Resources\MissingValue::class, $resource['students_count']);
    }
} 