<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_at' => fake()->dateTimeBetween($startDate = '-7 months', $endDate = 'now', $timezone = null),
            'reference' => fake()->uuid(),
            'converted' => fake()->randomElement($array = array (true,false)),
        ];
    }
}
