<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkIn = fake()->dateTimeBetween('now', '+30 days');
        $checkOut = (clone $checkIn)->modify('+' . rand(1, 5) . ' days');

        return [
            'room_id' => Room::factory(),
            'guest_name' => fake()->name(),
            'guest_phone' => fake()->phoneNumber(),
            'guest_email' => fake()->safeEmail(),
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'total_price' => fake()->randomFloat(2, 500000, 10000000),
            'status' => fake()->randomElement([
                'pending',
                'confirmed',
                'checked_in',
                'checked_out',
                'cancelled'
            ]),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
