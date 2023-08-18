<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
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
            'price_category' => fake()->randomElement($array = array ('standard','branch','country')),
            'price_tier' => fake()->randomElement($array = array ('standard','premium')),
            'online_hours' => fake()->numberBetween($min = 5, $max = 50),
            'offline_hours' => fake()->numberBetween($min = 5, $max = 50),
            'status' => fake()->randomElement($array = array (true,false)),
        ];
    }
}
