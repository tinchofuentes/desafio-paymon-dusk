<?php

namespace Database\Factories;

use App\Enums\CourseModality;
use App\Models\Academy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+2 months');
        $endDate = fake()->dateTimeBetween($startDate, '+6 months');
        
        return [
            'academy_id' => Academy::factory(),
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'cost' => fake()->randomFloat(2, 50, 500),
            'duration' => fake()->numberBetween(10, 120),
            'modality' => fake()->randomElement(CourseModality::cases()),
            'active' => fake()->boolean(80),
            'capacity' => fake()->numberBetween(10, 50),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
