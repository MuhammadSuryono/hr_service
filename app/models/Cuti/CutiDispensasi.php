<?php

namespace App\models\Cuti;

use App\User;

class CutiDispensasi extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'cuti_dispensasi';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
