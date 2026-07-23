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
}
