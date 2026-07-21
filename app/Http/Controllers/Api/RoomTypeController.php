<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomTypes = RoomType::latest()->paginate(10);

        return RoomTypeResource::collection($roomTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomTypeRequest $request)
    {
        $roomType = RoomType::create($request->validated());

        return new RoomTypeResource($roomType);
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomType $roomType)
    {
        return new RoomTypeResource($roomType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateRoomTypeRequest $request,
        RoomType $roomType
    ) {
        $roomType->update($request->validated());

        return new RoomTypeResource($roomType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $roomType)
    {
        try {
            $roomType->delete();

            return response()->json([
                'message' => 'Room type deleted successfully.'
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Cannot delete room type because it is being used by one or more rooms.'
            ], 409);
        }
    }
}
