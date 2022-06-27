<?php

namespace App\Http\Resources\Cuti;

use App\Helpers\Datetime;
use App\Helpers\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class CutiDispensasiDetailResource extends JsonResource
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
            'status_id' => $this->status,
            "status"=> Status::$status[$this->status],
            "document"=> $this->document,
            "users" => $this->userDispensasi != null ? $this->mapUserDispensasi() : []
        ];
    }

    public function mapUserDispensasi()
    {
        return $this->userDispensasi->map(function ($item) {
            return [
                'id' => $item->id,
                'full_name' => $item->user->full_name,
                'total' => $item->total
            ];
        });
    }
}
