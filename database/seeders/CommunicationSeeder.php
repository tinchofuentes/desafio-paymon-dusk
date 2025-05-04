<?php

namespace Database\Seeders;

use App\Models\Communication;
use App\Models\Course;
use App\Enums\CommunicationStatus;
use Illuminate\Database\Seeder;

class CommunicationSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::first();

        if (!$course) {
            $this->command->warn('No hay cursos disponibles para asociar el comunicado.');
            return;
        }

        Communication::create([
            'title' => 'Comunicado de prueba para edición',
            'message' => 'Este comunicado fue creado con un seeder para ser editado en un test.',
            'course_id' => $course->id,
            'age_from' => 12,
            'age_to' => 18,
            'send_date' => now()->addDays(5)->format('d-m-Y'),
            'status' => CommunicationStatus::SCHEDULED,
        ]);
    }
}
