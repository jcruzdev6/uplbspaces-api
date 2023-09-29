<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserProfileResource extends JsonResource
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
            'email' => $this->email,
            'is_verified' => $this->is_verified,
            'email_verified_at' => $this->email_verified_at,
            'remember_token' => $this->remember_token,
            'provider_id' => $this->provider_id,
            'provider' => $this->provider,
            'account_type' => $this->account_type,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'id_no' => $this->id_no,
            'department_unit_id' => $this->department_unit_id,
            'organization' => $this->organization,
            'id_filepath' => $this->id_filepath,
            'id_binary' => $this->getProfileIDBinary($this->id_filepath),
            'id_type' => $this->id_type,
            'department_unit_name' => ($this->department_unit_id != null) ? $this->department_unit->name : '',
            'department_unit_lname' => ($this->department_unit_id != null) ? $this->department_unit->long_name : '',
            'created_at' => $this->created_at->format('M d, Y h:m A'),
            'updated_at' => $this->updated_at->format('M d, Y h:m A')
        ];
    }

    public function with($request)
    {
        return [
            'success' => true
        ];
    }

    public function getProfileIDBinary($filePath) {
        $data = '';
        if ($filePath != null || $filePath != '')
            $data = 'data:image/png;base64,' . base64_encode( Storage::get($filePath) );
        return $data;
  }
}
