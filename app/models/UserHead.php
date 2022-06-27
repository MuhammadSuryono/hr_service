<?php

namespace App\models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserHead extends Model
{
    protected $table = 'user_head';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
