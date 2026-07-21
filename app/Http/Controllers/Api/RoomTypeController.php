<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;
use App\Services\RoomTypeService;
use App\Traits\ApiResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected RoomTypeService $roomTypeService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomTypes = $this->roomTypeService->getAll();

        return $this->success(
            RoomTypeResource::collection($roomTypes)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomTypeRequest $request)
    {
        $roomType = $this->roomTypeService->create(
            $request->validated()
        );

        return $this->success(
            new RoomTypeResource($roomType),
            'Room type created successfully.',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomType $roomType)
    {
        return $this->success(
            new RoomTypeResource($roomType)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateRoomTypeRequest $request,
        RoomType $roomType
    ) {
        $roomType = $this->roomTypeService->update(
            $roomType,
            $request->validated()
        );

        return $this->success(
            new RoomTypeResource($roomType),
            'Room type updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $roomType)
    {
        $this->roomTypeService->delete($roomType);

        return $this->success(
            null,
            'Room type deleted successfully.'
        );
    }
}
