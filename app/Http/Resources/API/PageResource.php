<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'content' => $this->content,
            'status' => $this->status,
            'rank' => $this->rank
        ];
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}
