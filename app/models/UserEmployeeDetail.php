<?php

namespace App\models;

use App\User as UserModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEmployeeDetail extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'user_employee_details';
    protected $guarded = [];
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
