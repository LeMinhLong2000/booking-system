<?php

namespace App\Services;

use App\Models\RoomType;

class RoomTypeService
{
    public function getAll()
    {
        return RoomType::query()
            ->orderBy('id')
            ->paginate(10);
    }

    public function create(array $data): RoomType
    {
        return RoomType::create($data);
    }

    public function update(RoomType $roomType, array $data): RoomType
    {
        $roomType->update($data);

        return $roomType->fresh();
    }

    public function delete(RoomType $roomType): bool
    {
        return $roomType->delete();
    }
}
