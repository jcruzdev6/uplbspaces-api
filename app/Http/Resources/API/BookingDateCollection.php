<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookingDateCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return 
            $this->collection->map(function ($booking_date) {
                return [
                    'id'   => $booking_date->id,
                    'booking_id' => $booking_date->booking_id,
                    'date' => $booking_date->date,
                    'start_time' => $booking_date->start_time,
                    'end_time' => $booking_date->end_time
                ];
            });
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}