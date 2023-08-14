<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class FAQResource extends JsonResource
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
            'question' => $this->question,
            'answer' => $this->answer,
            'enabled' => $this->enabled,
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
