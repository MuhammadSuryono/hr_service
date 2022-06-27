<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCutiKebijakanUpdate extends FormRequest
{
    public function rules()
    {
        return [
          'user_id' => 'required|int',
          'total' => 'required|int'
        ];
    }
}
