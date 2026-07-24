<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use ApiResponse;
    public function __construct(
        protected BookingService $bookingService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = $this->bookingService->getAll();

        return $this->success(
            BookingResource::collection($bookings)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $booking = $this->bookingService->create(
            $request->validated()
        );

        return $this->success(
            new BookingResource($booking->load('room')),
            'Booking created successfully.',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking = $this->bookingService->getById($booking->id);

        return $this->success(
            new BookingResource($booking)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateBookingRequest $request,
        Booking $booking
    ) {
        $booking = $this->bookingService->update(
            $booking,
            $request->validated()
        );

        return $this->success(
            new BookingResource($booking),
            'Booking updated successfully.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $this->bookingService->delete($booking);

        return $this->success(
            null,
            'Booking deleted successfully.'
        );
    }
}
