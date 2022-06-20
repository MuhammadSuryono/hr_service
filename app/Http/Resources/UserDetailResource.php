<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserDetailResource extends \Illuminate\Http\Resources\Json\JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'division' => $this->userDetail->division->name ?? 'Belum terdaftar',
            'level' => $this->userDetail->level->name ?? 'Belum terdaftar',
            'scopes' => $this->userScope != null ? $this->mapScope() : [],
        ];
    }

    protected function mapScope()
    {
        return $this->userScope->map(function ($scope) {
           return $scope->scope->scope;
        });
    }
}
