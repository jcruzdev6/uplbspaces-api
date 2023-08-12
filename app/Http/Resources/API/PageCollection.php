<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PageCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return 
            $this->collection->map(function ($page) {
                return [
                    'id'   => $page->id,
                    'name' => $page->name,
                    'rank' => $page->rank
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