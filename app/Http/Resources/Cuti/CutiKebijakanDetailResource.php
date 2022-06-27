<?php

namespace App\Http\Resources\Cuti;

use App\Helpers\Datetime;
use Illuminate\Http\Resources\Json\JsonResource;

class CutiKebijakanDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "start_month"=> Datetime::convertMonthToStringIndonesian($this->start_month),
            "start_year"=> $this->start_year,
            "end_month"=> Datetime::convertMonthToStringIndonesian($this->end_month),
            "end_year"=> $this->end_year,
            "status"=> $this->status ? 'Publish':'Belum Publish',
            "document"=> $this->document,
            "users" => $this->userKebijakan != null ? $this->mapUserKebijakan() : []
        ];
    }

    public function mapUserKebijakan()
    {
        return $this->userKebijakan->map(function ($item) {
            return [
                'id' => $item->id,
                'full_name' => $item->user->full_name,
                'total' => $item->total
            ];
        });
    }
}
