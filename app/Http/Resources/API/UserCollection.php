<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [
            $this->collection->map(function ($user) {
                return [
                    'id'   => $user->id,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'remember_token' => $user->remember_token,
                    //'socmed_acct' => $user->socmed_acct,
                    //'account_type' => $user->account_type,
                    //'first_name' => $user->first_name,
                    //'last_name' => $user->last_name,
                    //'department_unit_id' => $user->department_unit_id,
                    //'department_unit_name' => $user->department_unit->name,
                    //'department_unit_lname' => $user->department_unit->long_name,
                    //'id_no' => $user->id_no,
                    //'organization' => $user->organization,
                    //'id_filepath' => $user->id_filepath,
                    'id_type' => $user->id_type
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }
}