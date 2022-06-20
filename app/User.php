<?php

namespace App;

use App\models\Cuti\CutiPerdana;
use App\models\Cuti\CutiTahunan;
use App\models\Cuti\PenggunaanCuti;
use App\Models\UserBankAccount;
use App\Models\UserDetail;
use App\Models\UserDocument;
use App\models\UserScope;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string
     */
    protected string $guard_name = 'sanctum';

    /**
     * @return HasMany
     */
    public function userScope(): HasMany
    {
        return $this->hasMany(UserScope::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function documents()
    {
        return $this->hasMany(UserDocument::class, 'user_id');
    }

    /**
     * @return HasOne
     */
    public function userBank()
    {
        return $this->hasOne(UserBankAccount::class, 'user_id');
    }

    /**
     * @return HasOne
     */
    public function userDetail(): HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    public function leavePerdana(): HasOne
    {
        return $this->hasOne(CutiPerdana::class, 'user_id');
    }

    public function usageCuti($status)
    {
        return PenggunaanCuti::selectRaw('SUM(total_day) as total_usage')->where('user_id', auth()->user()->id)->where('usage_from', $status);
    }

    public function leaveBeforeYear(): HasOne
    {
        return $this->hasOne(CutiTahunan::class, 'user_id')->where('year', date("Y",strtotime("-1 year")));
    }

    public function usageCutiPreviousYear()
    {
        $previousYear = date("Y",strtotime("-1 year"));
        $currentYear = date('Y');
        return PenggunaanCuti::selectRaw('SUM(total_day) as total_usage')->where('user_id', auth()->user()->id)
            ->whereRaw("((YEAR(end_date) = '$currentYear' AND is_before_year = true) OR (YEAR(end_date) = '$previousYear' AND is_before_year = false))")
            ->where('usage_from', 'tahunan');
    }
}
