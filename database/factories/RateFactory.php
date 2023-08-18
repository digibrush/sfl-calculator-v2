<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rate>
 */
class RateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'standard_online_rate' => fake()->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 300) ,
            'standard_offline_rate' => fake()->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 300) ,
            'premium_online_rate' => fake()->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 300) ,
            'premium_offline_rate' => fake()->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 300) ,
        ];
    }
}
