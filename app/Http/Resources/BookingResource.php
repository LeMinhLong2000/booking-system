<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'guest_name' => $this->guest_name,

            'guest_phone' => $this->guest_phone,

            'guest_email' => $this->guest_email,

            'check_in' => $this->check_in,

            'check_out' => $this->check_out,

            'total_price' => $this->total_price,

            'status' => $this->status,

            'notes' => $this->notes,

            'room' => new RoomResource(
                $this->whenLoaded('room')
            )
        ];
    }
}
