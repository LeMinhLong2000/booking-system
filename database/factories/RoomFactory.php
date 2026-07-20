<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_type_id' => RoomType::factory(),
            'room_number' => fake()->unique()->numberBetween(101, 999),
            'floor' => fake()->numberBetween(1, 10),
            'status' => fake()->randomElement([
                'available',
                'occupied',
                'maintenance'
            ]),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
