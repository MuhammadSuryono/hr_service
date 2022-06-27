<?php

namespace App\Http\Requests;

class CutiKhususRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public static function rules(): array
    {
        return [
            'type_leave' => 'required|string|max:255',
            'location' => 'required',
            'document' => 'required',
            'document_other' => 'required',
            'related_people' => 'int',
            'status_people' => 'int',
        ];
    }
}
