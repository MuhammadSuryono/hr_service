<?php

namespace App\models\Cuti;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CutiKebijakan extends Model
{
    protected $table = 'cuti_kebijakan';
    protected $guarded = [];
    public $timestamps = true;

    public function submission(): BelongsTo
    {
        return $this->belongsTo(SubmissionCutiKebijakan::class, 'submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
