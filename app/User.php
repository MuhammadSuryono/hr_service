<?php

namespace App;

use App\models\Cuti\CutiDispensasi;
use App\models\Cuti\CutiKebijakan;
use App\models\Cuti\CutiPerdana;
use App\models\Cuti\CutiTahunan;
use App\models\Cuti\PenggunaanCuti;
use App\Models\UserBankAccount;
use App\Models\UserDetail;
use App\Models\UserDocument;
use App\models\UserEmployeeDetail;
use App\models\UserHead;
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

    public function leaveYear($year): HasOne
    {
        return $this->hasOne(CutiTahunan::class, 'user_id')->where('year', $year)->where('is_long', false);
    }

    public function usageCutiPreviousYear()
    {
        $previousYear = date("Y",strtotime("-1 year"));
        $currentYear = date('Y');
        return PenggunaanCuti::selectRaw('SUM(total_day) as total_usage')->where('user_id', auth()->user()->id)
            ->whereRaw("((YEAR(end_date) = '$currentYear' AND is_before_year = true) OR (YEAR(end_date) = '$previousYear' AND is_before_year = false))")
            ->where('usage_from', 'tahunan');
    }

    public function usageCutiCurrentYear()
    {
        $currentYear = date('Y');
        return PenggunaanCuti::selectRaw('SUM(total_day) as total_usage')->where('user_id', auth()->user()->id)
            ->whereYear('end_date',$currentYear)
            ->where('is_before_year', false)
            ->where('usage_from', 'tahunan');
    }

    public function leaveLongYear(): HasOne
    {
        return $this->hasOne(CutiTahunan::class, 'user_id')->where('year', date('Y'))->where('is_long', true);
    }

    public function usageCutiLongYear()
    {
        $currentYear = date('Y');
        return PenggunaanCuti::selectRaw('SUM(total_day) as total_usage')->where('user_id', auth()->user()->id)
            ->whereYear('end_date',$currentYear)
            ->where('is_before_year', false)
            ->where('usage_from', 'tahunan_panjang');
    }

    public function leaveDispensasi(): HasOne
    {
        return $this->hasOne(CutiDispensasi::class, 'user_id')->selectRaw('SUM(cuti_dispensasi.total) as total')
            ->join('submission_cuti_dispensasi', 'submission_cuti_dispensasi.id', '=', 'cuti_dispensasi.submission_id')
            ->where('status', 3)
            ->groupBy('user_id');
    }

    public function usageCutiDispensasi()
    {
        $currentYear = date('Y');
        return $this->hasOne(PenggunaanCuti::class, 'user_id')->selectRaw('SUM(total_day) as total_usage')->where('user_id', auth()->user()->id)
            ->where('is_before_year', false)
            ->where('usage_from', 'dispensasi');
    }

    public function leaveKebijakan()
    {
        return $this->hasOne(CutiKebijakan::class, 'user_id')->selectRaw('SUM(cuti_kebijakan.total) as total')
            ->join('submission_cuti_kebijakan', 'submission_cuti_kebijakan.id', '=', 'cuti_kebijakan.submission_id')
            ->where('submission_cuti_kebijakan.status', true)
            ->groupBy('user_id');
    }

    public function usageCutiKebijakan()
    {
        $currentYear = date('Y');
        return $this->hasOne(PenggunaanCuti::class, 'user_id')->selectRaw('SUM(total_day) as total_usage')->where('user_id', auth()->user()->id)
            ->where('usage_from', 'kebijakan');
    }

    /**
     * @return HasOne
     */
    public function userEmployeeDetail(): HasOne
    {
        return $this->hasOne(UserEmployeeDetail::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function userHead(): HasMany
    {
        return $this->hasMany(UserHead::class, 'user_id');
    }
}
