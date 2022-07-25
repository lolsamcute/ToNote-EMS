<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'pass_id' => $this->pass_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'department' => $this->department,
            'email' => $this->email,
            'address' => $this->address,
            'age' => $this->age,
            'is_verified' => $this->is_verified,
            'leave_status' => $this->leave_status,
        ];
    }
}
