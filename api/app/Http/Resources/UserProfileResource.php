<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'agent_registration_number' => $this->agent_registration_number,
            'is_admin' => $this->is_admin,
            'is_agent' => $this->is_agent,
            'is_tenant' => $this->is_tenant,
            'photo' => $this->photo,
            'bio' => $this->bio,
            'phone_number' => $this->phone_number,
            'deleted_at' => $this->deleted_at,
            'email' => $this->user->email,
            'name' => $this->user->name,
        ];
    }
}
