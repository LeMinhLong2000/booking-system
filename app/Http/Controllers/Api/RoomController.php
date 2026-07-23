<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Services\RoomService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    use ApiResponse;
    public function __construct(
        protected RoomService $roomService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = $this->roomService->getAll();

        return $this->success(
            RoomResource::collection($rooms)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $room = $this->roomService->create(
            $request->validated()
        );

        return $this->success(
            new RoomResource($room),
            'Room created successfully.',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = $this->roomService->getOne($id);

        return $this->success(
            new RoomResource($room)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateRoomRequest $request,
        Room $room
    ) {
        $room = $this->roomService->update(
            $room,
            $request->validated()
        );

        return $this->success(
            new RoomResource($room),
            'Room updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $this->roomService->delete($room);

        return $this->success(
            null,
            'Room deleted successfully.'
        );
    }
}
