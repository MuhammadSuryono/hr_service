<?php

namespace App\Http\Requests;

class LevelRequest
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
