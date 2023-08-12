<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FacilityTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return 
            $this->collection->map(function ($facility_type) {
                return [
                    'id' => $facility_type->id,
                    'name' => $facility_type->name,
                    'description' => $facility_type->description
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

