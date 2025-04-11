<?php

namespace Database\Seeders;

use App\Enums\Gender;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardian = Guardian::first();

        $students = [
            [
                'guardian_id' => $guardian->id,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'birth_date' => '2010-05-15',
                'gender' => Gender::MALE,
            ],
            [
                'guardian_id' => $guardian->id,
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'birth_date' => '2012-09-20',
                'gender' => Gender::FEMALE,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}
