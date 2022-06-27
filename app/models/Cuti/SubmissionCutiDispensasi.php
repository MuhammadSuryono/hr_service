<?php

namespace App\models\Cuti;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubmissionCutiDispensasi extends Model
{
    protected $table = 'submission_cuti_dispensasi';
    protected $guarded = [];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function userDispensasi(): HasMany
    {
        return $this->hasMany(CutiDispensasi::class, 'submission_id');
    }
}
