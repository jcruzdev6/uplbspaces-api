<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentUnitCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return 
            $this->collection->map(function ($department_unit) {
                return [
                    'id' => $department_unit->id,
                    'name' => $department_unit->name,
                    'long_name' => $department_unit->long_name,
                    'parent_id' => $department_unit->parent_id,
                    'parent_name' => ($department_unit->parent_id != null) ? $department_unit->parent->name : '',
                    'parent_long_name' => ($department_unit->parent_id != null) ? $department_unit->parent->long_name : '',
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

