<?php

namespace App\Http\Resources\Cuti;

use App\Helpers\Datetime;
use Illuminate\Http\Resources\Json\JsonResource;

class CutiKebijakanList extends JsonResource
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
            "last_updated_by"=> $this->updatedBy->full_name ?? $this->createdBy->full_name ?? '',
            "status"=> $this->status ? 'Publish':'Belum Publish',
            "updated_at"=> date('Y-m-d h:i:s', strtotime($this->updated_at)),
            "document"=> $this->document,
            "total_user" => $this->userKebijakan->count() ?? 0
        ];
    }
}
