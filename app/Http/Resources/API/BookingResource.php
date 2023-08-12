<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
                    'booking_no' => $this->booking_no,
                    'contact_person' => $this->contact_person,
                    'event_title' => $this->event_title,
                    'type_of_use' => $this->type_of_use,
                    'num_participants' => $this->num_participants,
                    'sponsors' => $this->sponsors,
                    'reqd_resources' => $this->reqd_resources,
                    'addtnl_request' => $this->addtnl_request,
                    'status' => $this->status,
                    'waive_fee_doc' => $this->waive_fee_doc,
                    'preapproved_by' => $this->preapproved_by,
                    'approved_by' => $this->approved_by,
                    'verified_by' => $this->verified_by,
                    'reviewed_by' => $this->reviewed_by,
                    'booked_by' => $this->booked_by,
                    'booking_dates' => $this->when(count($this->booking_dates) > 0, BookingDateResource::collection($this->booking_dates))
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
