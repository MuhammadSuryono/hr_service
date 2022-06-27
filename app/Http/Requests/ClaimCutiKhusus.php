<?php

namespace App\Http\Requests;

class ClaimCutiKhusus extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules()
    {
        return [
            'start_date' => 'required|string|max:255',
            'end_date' => 'required',
            'id_more_than' => 'required',
            'document_claim' => 'required',
            'description' => 'string',
        ];
    }
}
