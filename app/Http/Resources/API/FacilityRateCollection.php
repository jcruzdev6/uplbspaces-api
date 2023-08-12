<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FacilityRateCollection extends ResourceCollection
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
                'facility_rate' => $this->collection->map(function ($facility_rate) {
                        return [
                            'id' => $facility_rate->id,
                            'facility_id' => $facility_rate->facility_id,
                            'up_rate' => $facility_rate->up_rate,
                            'nonup_rate' => $facility_rate->nonup_rate,
                            'type' => $facility_rate->type,
                            'category' => $facility_rate->category,
                            'with_aircon' => $facility_rate->with_aircon,
                            'description' => $facility_rate->description
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

