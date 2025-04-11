<?php

namespace Database\Factories;

use App\Enums\CommunicationStatus;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Communication>
 */
class CommunicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'title' => fake()->sentence(),
            'message' => fake()->paragraphs(3, true),
            'send_date' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'status' => fake()->randomElement(CommunicationStatus::cases()),
            'age_from' => fake()->optional(0.3)->numberBetween(5, 10),
            'age_to' => fake()->optional(0.3)->numberBetween(11, 18),
        ];
    }
}
