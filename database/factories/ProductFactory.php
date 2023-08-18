<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words($nb = 3, $asText = true),
            'overview' => fake()->sentence($nbWords = 20, $variableNbWords = true),
            'status' => fake()->randomElement($array = array (true,false)),
        ];
    }
}
