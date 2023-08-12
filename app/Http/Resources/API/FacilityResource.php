<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class FacilityResource extends JsonResource
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
            'name' => $this->name,
            'department_unit_id' => $this->department_unit_id ?? '',
            'department_unit_name' => $this->department_unit->name ?? '',
            'department_unit_lname' => $this->department_unit->long_name ?? '',
            'address' => $this->address,
            'location' => $this->location,
            'google_place_id' => $this->google_place_id,
            'min_capacity' => $this->min_capacity,
            'max_capacity' => $this->max_capacity,
            'available_days' => $this->available_days,
            'available_days_grp' => $this->getGroupedDays(),
            'available_hrs' => $this->available_hrs,
            'equipments_available' => $this->equipments_available,
            'facility_type_id' => $this->facility_type_id,
            'facility_rates' => $this->when(count($this->facility_rates) > 0, FacilityRateResource::collection($this->facility_rates))
        ];
        
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}
