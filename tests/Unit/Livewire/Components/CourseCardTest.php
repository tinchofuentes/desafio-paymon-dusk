<?php

namespace Tests\Unit\Livewire\Components;

use App\Enums\CourseModality;
use App\Livewire\Components\CourseCard;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CourseCardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the component can be rendered with a course.
     */
    public function test_component_can_render_with_course(): void
    {
        $course = Course::factory()->create([
            'name' => 'Test Course',
            'description' => 'Course Description',
            'cost' => 150.00
        ]);

        Livewire::test(CourseCard::class, ['course' => $course])
            ->assertStatus(200)
            ->assertSee('Test Course')
            ->assertSee('Course Description')
            ->assertSee('150');
    }

    /**
     * Test the component correctly displays course cost.
     */
    public function test_component_displays_course_cost(): void
    {
        $course = Course::factory()->create([
            'cost' => 299.99
        ]);

        Livewire::test(CourseCard::class, ['course' => $course])
            ->assertStatus(200)
            ->assertSee('299.99');
    }

    /**
     * Test the component correctly displays course capacity.
     */
    public function test_component_displays_course_capacity(): void
    {
        $course = Course::factory()->create([
            'capacity' => 25,
            'duration' => 30
        ]);

        Livewire::test(CourseCard::class, ['course' => $course])
            ->assertStatus(200)
            ->assertSee('30 hours');
    }

    /**
     * Test the component correctly displays start and end dates.
     */
    public function test_component_displays_course_dates(): void
    {
        $startDate = now()->addDays(10);
        
        $course = Course::factory()->create([
            'start_date' => $startDate
        ]);

        Livewire::test(CourseCard::class, ['course' => $course])
            ->assertStatus(200)
            ->assertSee($startDate->format('M d, Y'));
    }

    /**
     * Test the component correctly displays the modality.
     */
    public function test_component_displays_course_modality(): void
    {
        $course = Course::factory()->create([
            'modality' => CourseModality::ONLINE
        ]);

        Livewire::test(CourseCard::class, ['course' => $course])
            ->assertStatus(200)
            ->assertSee(str_replace('-', ' ', $course->modality->value));
    }
} 