<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        RoomType::factory()
            ->count(5)
            ->has(Room::factory()->count(5))
            ->create();

        $rooms = Room::all();

        foreach ($rooms as $room) {
            Booking::factory()
                ->count(rand(0, 3))
                ->create([
                    'room_id' => $room->id,
                ]);
        }
    }
}
