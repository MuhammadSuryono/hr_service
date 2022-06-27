<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionRequest extends FormRequest
{

    /**
     * @return string[]
     */
    public static function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'start_month' => 'required|int',
            'start_year' => 'required|int',
            'end_month' => 'required|int',
            'end_year' => 'required|int',
            'document' => 'required'
        ];
    }
}
