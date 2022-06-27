<?php

namespace App\Http\Resources\Cuti;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportingRekapitulasiCutiKaryawan extends JsonResource
{
    public function toArray($request)
    {
        $userDetail = $this->userEmployeeDetail;

        $longLeaveYear = $this->leaveLongYear;

        $penggunaanCutiPerdana = $longLeaveYear != null ? 0 : $this->usageCuti('perdana')->first()->total_usage ?? 0;
        $totalCutiPerdana = $longLeaveYear != null ? 0 : $this->leavePerdana->total_cuti ?? 0;
        $sisaCutiperdana = $totalCutiPerdana > 0 ? $totalCutiPerdana - $penggunaanCutiPerdana : 0;
        $totalPenggunaanCutiPerdana =  $totalCutiPerdana > 0 ? $totalCutiPerdana - $sisaCutiperdana : 0;

        $dataCutiTahunLalu = $this->leaveYear(date("Y",strtotime("-1 year")))->first();
        $isReset = date('m') > ($dataCutiTahunLalu->next_month_reset ?? null);
        $totalCutiTahunLalu = !$isReset ? $dataCutiTahunLalu->total ?? 0 : 0;
        $totalPenggunaanCutiTahunLalu = !$isReset ? $this->usageCutiPreviousYear()->first()->total_usage ?? 0 : 0;
        $sisaCutiTahunLalu = $totalCutiTahunLalu > 0 ? $totalCutiTahunLalu - $totalPenggunaanCutiTahunLalu : 0;

        $totalCutiTahunBerjalan = $this->leaveYear(date("Y"))->first()->total ?? 0;
        $totalPenggunaanCutiBerjalan= $totalCutiTahunBerjalan > 0 ? $this->usageCutiCurrentYear()->first()->total_usage ?? 0 : 0;
        $sisaCutiTahunBerjalan = $totalCutiTahunBerjalan > 0 ? $totalCutiTahunBerjalan - $totalPenggunaanCutiBerjalan : 0;

        $totalLongLeaveYear = $longLeaveYear->total ?? 0;
        $totalPenggunaanCutiLongLeaveYear = $this->usageCutiLongYear()->first()->total_usage ?? 0;
        $sisaCutiLongYear = $totalLongLeaveYear > 0 ? $totalLongLeaveYear - $totalPenggunaanCutiLongLeaveYear : 0;

        $totalLeaveDispensasi = $this->leaveDispensasi->total ?? 0;
        $totalPenggunaanCutiDispensasi = $this->usageCutiDispensasi->total ?? 0;
        $sisaCutiDispensasi = $totalLeaveDispensasi > 0 ? $totalLeaveDispensasi - $totalPenggunaanCutiDispensasi : 0;

        $totalCutiKebijakan = $this->leaveKebijakan->total ?? 0;
        $totalPenggunaanCutiKebijakan = $this->usageCutiKebijakan->total ?? 0;
        $sisaCutiKebiajakn = $totalCutiKebijakan > 0 ? $totalCutiKebijakan - $totalPenggunaanCutiKebijakan : 0;
        return [
            'user_id' => $this->id,
            'full_name' => $this->full_name,
            'division' => $userDetail->division->name ?? 'Belum terdaftar',
            'level' => $userDetail->level->name ?? 'Belum terdaftar',
            'status_employee' => $userDetail->status_employee ?? 'Belum Di Atur',
            'date_in' => $userDetail->start_contract ?? 'Belum Di Atur',
            'date_out' => $userDetail->start_contract ?? 'Belum Di Atur',
            'head_division' => $this->userHead !== null ? implode(" , ", $this->mapUserHead()->toArray()) : "-",
            'grand_total' => $sisaCutiperdana + $sisaCutiTahunLalu + $sisaCutiTahunBerjalan + $sisaCutiLongYear + $sisaCutiDispensasi + $sisaCutiKebiajakn,
            'leaves' => [
                'perdana' => [
                    "total_paid_leave" => $totalCutiPerdana,
                    "remaining_days_off" => $sisaCutiperdana,
                    "description"=> "$totalPenggunaanCutiPerdana hari telah digunakan"
                ],
                'tahun_lalu' => [
                    "total_paid_leave" => $totalCutiTahunLalu,
                    "remaining_days_off" => $sisaCutiTahunLalu,
                    "description"=> "$totalPenggunaanCutiTahunLalu hari telah digunakan"
                ],
                'tahun_sekarang' => [
                    "total_paid_leave" => $totalCutiTahunBerjalan,
                    "remaining_days_off" => $sisaCutiTahunBerjalan,
                    "description"=> "$totalPenggunaanCutiBerjalan hari telah digunakan"
                ],
                'cuti_panjang' => [
                    "total_paid_leave" => $totalLongLeaveYear,
                    "remaining_days_off" => $sisaCutiLongYear,
                    "description"=> "$totalLongLeaveYear hari telah digunakan"
                ],
                'dispensasi' => [
                    "total_paid_leave" => $totalLeaveDispensasi,
                    "remaining_days_off" => $sisaCutiDispensasi,
                    "description"=> "$totalPenggunaanCutiDispensasi hari telah digunakan"
                ],
                'kebijakan' => [
                    "total_paid_leave" => $totalCutiKebijakan,
                    "remaining_days_off" => $sisaCutiKebiajakn,
                    "description"=> "$totalPenggunaanCutiKebijakan hari telah digunakan"
                ]
            ]
        ];
    }

    protected function mapUserHead()
    {
        return $this->userHead->map(function ($head) {
            return $head->user->full_name;
        });
    }
}
