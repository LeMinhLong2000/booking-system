<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\RoomService;

class BookingService
{
    private const STATUS_FLOW = [

        'pending' => [
            'confirmed',
            'cancelled'
        ],

        'confirmed' => [
            'checked_in',
            'cancelled'
        ],

        'checked_in' => [
            'checked_out'
        ],

        'checked_out' => [],

        'cancelled' => [],
    ];

    public function __construct(
        private RoomService $roomService
    ) {}


    public function getAll()
    {
        return Booking::query()
            ->with('room')
            ->latest()
            ->paginate(10);
    }

    public function getById(int $id): Booking
    {
        return Booking::with('room')
            ->findOrFail($id);
    }

    public function create(array $data): Booking
    {
        $this->ensureRoomIsAvailable(
            $data['room_id'],
            $data['check_in'],
            $data['check_out']
        );

        return Booking::create($data);
    }

    public function update(
        Booking $booking,
        array $data
    ): Booking {

        $this->ensureRoomIsAvailable(
            $data['room_id'],
            $data['check_in'],
            $data['check_out'],
            $booking->id
        );

        $booking->update($data);

        return $booking->load('room');
    }

    public function delete(
        Booking $booking
    ): void {

        $booking->delete();
    }

    private function isRoomAvailable(
        int $roomId,
        string $checkIn,
        string $checkOut,
        ?int $ignoreBookingId = null
    ): bool {
        $query = Booking::query()
            ->where('room_id', $roomId)
            ->whereIn('status', [
                'pending',
                'confirmed',
                'checked_in',
            ])
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query
                    ->where('check_in', '<', $checkOut)
                    ->where('check_out', '>', $checkIn);
            });

        if ($ignoreBookingId !== null) {
            $query->where('id', '!=', $ignoreBookingId);
        }

        return ! $query->exists();
    }

    private function ensureRoomIsAvailable(
        int $roomId,
        string $checkIn,
        string $checkOut,
        ?int $ignoreBookingId = null
    ): void {
        if (! $this->isRoomAvailable(
            $roomId,
            $checkIn,
            $checkOut,
            $ignoreBookingId
        )) {
            throw ValidationException::withMessages([
                'room_id' => [
                    'The room is not available for the selected dates.'
                ]
            ]);
        }
    }

    private function canChangeStatus(
        string $currentStatus,
        string $newStatus
    ): bool {
        return in_array(
            $newStatus,
            self::STATUS_FLOW[$currentStatus] ?? [],
            true
        );
    }


    public function changeStatus(
        Booking $booking,
        string $newStatus
    ): Booking {

        if (! $this->canChangeStatus(
            $booking->status,
            $newStatus
        )) {

            throw ValidationException::withMessages([
                'status' => [
                    'Invalid booking status transition.'
                ]
            ]);
        }

        DB::transaction(function () use (
            $booking,
            $newStatus
        ) {

            $booking->update([
                'status' => $newStatus
            ]);

            $this->syncRoomStatus(
                $booking,
                $newStatus
            );
        });

        return $booking->fresh()->load('room');
    }

    private function syncRoomStatus(
        Booking $booking,
        string $newStatus
    ): void {
        $room = $booking->room;

        switch ($newStatus) {

            case 'checked_in':

                $this->roomService
                    ->markOccupied($room);

                break;

            case 'checked_out':

                $this->roomService
                    ->markAvailable($room);

                break;
        }
    }
}
