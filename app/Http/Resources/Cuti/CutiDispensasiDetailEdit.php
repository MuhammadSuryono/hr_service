<?php

namespace App\Http\Resources\Cuti;

use Illuminate\Http\Resources\Json\JsonResource;

class CutiDispensasiDetailEdit extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id"=> $this->id,
            "title"=> $this->title,
            "start_month"=> $this->start_month,
            "start_year"=> $this->start_year,
            "end_month"=> $this->end_month,
            "end_year"=> $this->end_year,
            'status' => $this->status,
            "document"=> $this->document,
            "users" => $this->userDispensasi != null ? $this->mapUserDispensasi() : []
        ];
    }

    public function mapUserDispensasi()
    {
        return $this->userDispensasi->map(function ($item) {
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'total' => $item->total
            ];
        });
    }
}
