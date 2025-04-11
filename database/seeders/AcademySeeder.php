<?php

namespace Database\Seeders;

use App\Models\Academy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academies = [
            [
                'name' => 'Mathematics Academy',
                'description' => 'Specialized in mathematics and related fields.',
                'active' => true,
            ],
            [
                'name' => 'Language Arts Academy',
                'description' => 'Focusing on language skills and literature.',
                'active' => true,
            ],
            [
                'name' => 'Science Academy',
                'description' => 'Dedicated to scientific disciplines and research.',
                'active' => true,
            ],
        ];

        foreach ($academies as $academy) {
            Academy::create($academy);
        }
    }
}
