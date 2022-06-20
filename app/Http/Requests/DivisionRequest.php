<?php

namespace App\Http\Requests;

class DivisionRequest
{
    /**
     * @return string[]
     */
    public static function validation(): array
    {
        return [
            'name' => 'required|string|max:255|unique:divisions,name',
        ];
    }
}
