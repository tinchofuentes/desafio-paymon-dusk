<?php

namespace Database\Seeders;

use App\Enums\CourseModality;
use App\Models\Academy;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mathAcademy = Academy::where('name', 'Mathematics Academy')->first();
        $langAcademy = Academy::where('name', 'Language Arts Academy')->first();
        $scienceAcademy = Academy::where('name', 'Science Academy')->first();

        $courses = [
            [
                'academy_id' => $mathAcademy->id,
                'name' => 'Algebra I',
                'description' => 'Introduction to algebraic concepts.',
                'cost' => 150.00,
                'duration' => 40,
                'modality' => CourseModality::IN_PERSON,
                'active' => true,
                'capacity' => 20,
                'start_date' => now()->addDays(15),
                'end_date' => now()->addDays(75),
            ],
            [
                'academy_id' => $mathAcademy->id,
                'name' => 'Geometry',
                'description' => 'Study of shapes, sizes, and properties of space.',
                'cost' => 175.00,
                'duration' => 45,
                'modality' => CourseModality::HYBRID,
                'active' => true,
                'capacity' => 18,
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(80),
            ],
            [
                'academy_id' => $langAcademy->id,
                'name' => 'Creative Writing',
                'description' => 'Develop creative writing skills and techniques.',
                'cost' => 120.00,
                'duration' => 30,
                'modality' => CourseModality::IN_PERSON,
                'active' => true,
                'capacity' => 15,
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(65),
            ],
            [
                'academy_id' => $langAcademy->id,
                'name' => 'Spanish for Beginners',
                'description' => 'Introduction to Spanish language.',
                'cost' => 130.00,
                'duration' => 36,
                'modality' => CourseModality::ONLINE,
                'active' => true,
                'capacity' => 25,
                'start_date' => now()->addDays(20),
                'end_date' => now()->addDays(90),
            ],
            [
                'academy_id' => $scienceAcademy->id,
                'name' => 'Biology Fundamentals',
                'description' => 'Introduction to biology and living organisms.',
                'cost' => 200.00,
                'duration' => 50,
                'modality' => CourseModality::HYBRID,
                'active' => true,
                'capacity' => 22,
                'start_date' => now()->addDays(7),
                'end_date' => now()->addDays(85),
            ],
            [
                'academy_id' => $scienceAcademy->id,
                'name' => 'Chemistry Basics',
                'description' => 'Introduction to chemistry concepts.',
                'cost' => 210.00,
                'duration' => 48,
                'modality' => CourseModality::IN_PERSON,
                'active' => true,
                'capacity' => 20,
                'start_date' => now()->addDays(12),
                'end_date' => now()->addDays(92),
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
