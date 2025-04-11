<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enrollment_id' => Enrollment::factory(),
            'amount' => fake()->randomFloat(2, 50, 1000),
            'payment_date' => fake()->dateTimeBetween('-30 days', 'now'),
            'method' => fake()->randomElement(PaymentMethod::cases()),
            'status' => fake()->randomElement(PaymentStatus::cases()),
            'reference_number' => fake()->optional(0.7)->uuid(),
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }
}
