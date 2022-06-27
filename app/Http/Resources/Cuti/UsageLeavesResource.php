<?php

namespace App\Http\Resources\Cuti;

use Illuminate\Http\Resources\Json\JsonResource;

class UsageLeavesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'category_leaves' => $this->category_cuti,
            'total_day' => $this->total_day,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "description" => $this->description,
        ];
    }
}
