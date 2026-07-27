<?php

namespace App\Services;

use App\Models\Room;

class RoomService
{
    public function getAll()
    {
        return Room::query()
            ->with('roomType')
            ->orderBy('id')
            ->paginate(10);
    }

    public function getOne(string $id)
    {
        return Room::with('roomType')
            ->find($id);
    }

    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(Room $room, array $data): Room
    {
        $room->update($data);

        return $room->fresh();
    }

    public function delete(Room $room): bool
    {
        return $room->delete();
    }

    public function markOccupied(Room $room): Room
    {
        $room->update([
            'status' => 'occupied'
        ]);

        return $room->fresh();
    }

    public function markAvailable(Room $room): Room
    {
        if ($room->status === 'maintenance') {
            return $room;
        }

        $room->update([
            'status' => 'available'
        ]);

        return $room->fresh();
    }

    public function markMaintenance(Room $room): Room
{
    $room->update([
        'status' => 'maintenance'
    ]);

    return $room->fresh();
}
}
