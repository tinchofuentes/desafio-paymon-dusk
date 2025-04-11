<?php

namespace App\Livewire\Components;

use App\Models\Course;
use Livewire\Component;

class CourseCard extends Component
{
    public Course $course;

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function render()
    {
        return view('livewire.components.course-card');
    }
} 