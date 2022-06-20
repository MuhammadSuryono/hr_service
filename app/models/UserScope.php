<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserScope extends Model
{
    protected $table = 'user_scopes';
    protected $guarded = [];

    public function scope(): BelongsTo
    {
        return $this->belongsTo(Scopes::class, 'scope_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
