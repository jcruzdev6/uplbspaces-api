<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminUserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'admin_users' => $this->collection->map(function ($admin_user) {
                    return [
                        'id'   => $admin_user->id,
                        'email' => $admin_user->email
                    ];
                })
            ]
        ];
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}