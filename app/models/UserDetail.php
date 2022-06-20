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

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
}
