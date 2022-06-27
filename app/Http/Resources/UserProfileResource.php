<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'nik' => $this->userDetail->nik ?? '',
            'gender' => $this->userDetail->gender ?? '',
            'place_of_birth' => $this->userDetail->place_of_birth ?? '',
            'date_of_birth' => $this->userDetail->date_of_birth ?? '',
            'is_married' => $this->userDetail->is_married ?? 0,
            'total_liability' => $this->userDetail->total_liability ?? 0,
            'blood_of_group' => $this->userDetail->blood_of_group ?? '',
            'height' => $this->userDetail->height ?? 0,
            'weight' => $this->userDetail->weight ?? 0,
            'education' => $this->userDetail->weight ?? '',
            'nationality' => $this->userDetail->weight ?? 'wni',
            'religion' => $this->userDetail->religion ?? 0,
            'address' => $this->userDetail->address ?? 0,
        ];
    }
}
