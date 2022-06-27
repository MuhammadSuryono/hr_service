<?php

namespace App\Models;

use App\User as UserModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends \Illuminate\Database\Eloquent\Model
{

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class);
    }
}
