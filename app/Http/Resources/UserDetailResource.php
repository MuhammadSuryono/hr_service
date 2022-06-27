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
            'division' => $this->userEmployeeDetail->division->name ?? 'Belum terdaftar',
            'level' => $this->userEmployeeDetail->level->name ?? 'Belum terdaftar',
            'head_division' => $this->userHead !== null ? $this->mapUserHead() : [],
            'scopes' => $this->userScope != null ? $this->mapScope() : [],
        ];
    }

    protected function mapScope()
    {
        return $this->userScope->map(function ($scope) {
           return $scope->scope->scope;
        });
    }

    protected function mapUserHead()
    {
        return $this->userHead->map(function ($head) {
           return [
               'id' => $head->head_user_id,
               'name' => $head->user->full_name,
           ];
        });
    }
}
