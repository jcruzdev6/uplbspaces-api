<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentUnitResource extends JsonResource
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
            'name' => $this->name,
            'long_name' => $this->long_name,
            'parent_id' => $this->parent_id,
            'parent_name' => $this->parent->name,
            'parent_long_name' => $this->parent->long_name,
        ];
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}
