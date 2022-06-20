<?php

namespace App\Http\Requests;

class UserUpdateRequest
{
    /**
     * @return string[]
     */
    public static function validation(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|min:9|max:16',
        ];
    }
}
