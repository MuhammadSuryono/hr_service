<?php

namespace App\models\Cuti;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SubmissionCutiKebijakan extends Model
{
    protected $table = 'submission_cuti_kebijakan';
    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function userKebijakan()
    {
        return $this->hasMany(CutiKebijakan::class, 'submission_id');
    }
}
