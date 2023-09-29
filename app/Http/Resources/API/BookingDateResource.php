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
                'id'   => $this->id,
                'booking_id' => $this->booking_id,
                'date' => date('m d, Y', strtotime($this->date)),
                'date_raw' => date('Y-m-d', strtotime($this->date)),
                'start_time' => date('h:i A', strtotime($this->start_time)),
                'end_time' => date('h:i A', strtotime($this->end_time)),
                'start_time_raw' => date('H', strtotime($this->start_time)),
                'end_time_raw' => date('H', strtotime($this->end_time))
        ];
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}
