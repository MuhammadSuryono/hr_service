<?php

namespace App\Http\Requests;

class PositionRequest
{
    /**
     * @return string[]
     */
    public static function validation(): array
    {
        return [
            'name' => 'required|string|max:255|unique:positions,name',
        ];
    }
}
