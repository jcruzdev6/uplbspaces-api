<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FacilityCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return 
            $this->collection->map(function ($facility) {
                return [
                    'id'   => $facility->id,
                    'name' => $facility->name,
                    'address' => $facility->address,
                    'min_capacity' => $facility->min_capacity,
                    'max_capacity' => $facility->max_capacity,
                    'available_days' => $facility->available_days,
                    'available_days_grp' => $facility->getGroupedDays(),
                    'available_hrs' => $facility->available_hrs,
                    'facility_type_id' => $facility->facility_type_id,
                    //'facility_rates' => FacilityRateResource::collection($facility->getMainFacilityRates())
                    'facility_rates' => $this->when(count($facility->facility_rates->where('category', 'facility')) > 0, FacilityRateResource::collection($facility->facility_rates->where('category', 'facility')))
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