<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingDateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'this' => [
                    'id'   => $this->id,
                    'booking_id' => $this->booking_id,
                    'date' => $this->date,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time
                ]
            ]
        ];
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}
