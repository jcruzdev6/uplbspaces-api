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
        return [
            'data' => [
                'booking' => $this->collection->map(function ($booking) {
                    return [
                        'id'   => $booking->id,
                        'booking_no' => $booking->booking_no,
                        'contact_person' => $booking->contact_person,
                        'event_title' => $booking->event_title,
                        'type_of_use' => $booking->type_of_use,
                        'num_participants' => $booking->num_participants,
                        'sponsors' => $booking->sponsors,
                        'reqd_resources' => $booking->reqd_resources,
                        'addtnl_request' => $booking->addtnl_request,
                        'status' => $booking->status,
                        'waive_fee_doc' => $booking->waive_fee_doc,
                        'preapproved_by' => $booking->preapproved_by,
                        'approved_by' => $booking->approved_by,
                        'verified_by' => $booking->verified_by,
                        'reviewed_by' => $booking->reviewed_by,
                        'booked_by' => $booking->booked_by,
                    ];
                })
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