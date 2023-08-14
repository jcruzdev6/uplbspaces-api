<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class FAQCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return 
            $this->collection->map(function ($faq) {
                return [
                    'id'   => $faq->id,
                    'question' => $faq->question,
                    'answer' => $faq->answer,
                    'enabled' => $faq->enabled,
                    'rank' => $faq->rank
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