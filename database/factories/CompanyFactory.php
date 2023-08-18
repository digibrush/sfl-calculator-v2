<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => fake()->dateTimeBetween($startDate = '-3 months', $endDate = 'now', $timezone = null),
            'name' => fake()->company(),
            'address_1' => fake()->streetAddress(),
            'address_2' => fake()->streetName(),
            'city' => fake()->city(),
            'state' => fake()->state,
            'country' => fake()->country(),
        ];
    }
}
