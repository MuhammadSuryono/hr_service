<?php

namespace App\Http\Requests;

class UserCreateRequest
{
    /**
     * @return string[]
     */
    public static function validation(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone_number' => 'required|string|min:9|max:16|unique:users',
            'username' => 'required|string|max:255|unique:users',
        ];
    }
}
