<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Standard',
                'Superior',
                'Deluxe',
                'Suite',
                'Family'
            ]),
            'price_per_night' => fake()->randomFloat(2, 300000, 2500000),
            'capacity' => fake()->numberBetween(1, 6),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
