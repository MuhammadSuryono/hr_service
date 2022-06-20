<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFamilyCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'status_family' => 'required|string|in:child,wife,husband,parents,parents_in_law',
            'date_of_birth' => 'required|string',
            'place_of_birth' => 'required|string',
            'full_name' => 'required|string',
            'profession' => 'string'
        ];
    }
}
