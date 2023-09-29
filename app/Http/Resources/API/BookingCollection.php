<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BookingCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return 
            $this->collection->map(function ($booking) {
                return [
                        'id'   => $booking->id,
                        'booking_no' => $booking->booking_no,
                        'facility_id' => $booking->facility_id,
                        'facility_name' => $booking->facility->name,
                        'contact_person' => $booking->contact_person,
                        'event_title' => $booking->event_title,
                        'sponsors' => $booking->sponsors,
                        'cost' => $booking->cost,
                        'amount_paid' => $booking->amount_paid,
                        'status' => $booking->status,
                        'booking_dates' => $booking->when(count($booking->booking_dates) > 0, BookingDateResource::collection($booking->booking_dates))
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