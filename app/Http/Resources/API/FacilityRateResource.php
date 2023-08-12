<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class FacilityRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'facility_id' => $this->facility_id,
            'up_rate' => $this->up_rate,
            'nonup_rate' => $this->nonup_rate,
            'type' => $this->type,
            'category' => $this->category,
            'with_aircon' => $this->with_aircon,
            'description' => $this->description,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}
