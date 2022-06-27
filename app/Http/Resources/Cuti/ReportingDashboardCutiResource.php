<?php

namespace App\Http\Resources\Cuti;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportingDashboardCutiResource extends JsonResource
{
    public function toArray($request)
    {
        $user = auth()->user();
        $userDetail = $user->userEmployeeDetail;

        $longLeaveYear = $user->leaveLongYear;

        $penggunaanCutiPerdana = $longLeaveYear != null ? 0 : $user->usageCuti('perdana')->first()->total_usage ?? 0;
        $totalCutiPerdana = $longLeaveYear != null ? 0 : $user->leavePerdana->total_cuti ?? 0;
        $sisaCutiperdana = $totalCutiPerdana > 0 ? $totalCutiPerdana - $penggunaanCutiPerdana : 0;
        $totalPenggunaanCutiPerdana =  $totalCutiPerdana > 0 ? $totalCutiPerdana - $sisaCutiperdana : 0;

        $dataCutiTahunLalu = $user->leaveYear(date("Y",strtotime("-1 year")))->first();
        $isReset = date('m') > ($dataCutiTahunLalu->next_month_reset ?? null);
        $totalCutiTahunLalu = !$isReset ? $dataCutiTahunLalu->total ?? 0 : 0;
        $totalPenggunaanCutiTahunLalu = !$isReset ? $user->usageCutiPreviousYear()->first()->total_usage ?? 0 : 0;
        $sisaCutiTahunLalu = $totalCutiTahunLalu > 0 ? $totalCutiTahunLalu - $totalPenggunaanCutiTahunLalu : 0;

        $totalCutiTahunBerjalan = $user->leaveYear(date("Y"))->first()->total ?? 0;
        $totalPenggunaanCutiBerjalan= $totalCutiTahunBerjalan > 0 ? $user->usageCutiCurrentYear()->first()->total_usage ?? 0 : 0;
        $sisaCutiTahunBerjalan = $totalCutiTahunBerjalan > 0 ? $totalCutiTahunBerjalan - $totalPenggunaanCutiBerjalan : 0;

        $totalLongLeaveYear = $longLeaveYear->total ?? 0;
        $totalPenggunaanCutiLongLeaveYear = $user->usageCutiLongYear()->first()->total_usage ?? 0;
        $sisaCutiLongYear = $totalLongLeaveYear > 0 ? $totalLongLeaveYear - $totalPenggunaanCutiLongLeaveYear : 0;

        $totalLeaveDispensasi = $user->leaveDispensasi->total ?? 0;
        $totalPenggunaanCutiDispensasi = $user->usageCutiDispensasi->total ?? 0;
        $sisaCutiDispensasi = $totalLeaveDispensasi > 0 ? $totalLeaveDispensasi - $totalPenggunaanCutiDispensasi : 0;

        $totalCutiKebijakan = $user->leaveKebijakan->total ?? 0;
        $totalPenggunaanCutiKebijakan = $user->usageCutiKebijakan->total ?? 0;
        $sisaCutiKebiajakn = $totalCutiKebijakan > 0 ? $totalCutiKebijakan - $totalPenggunaanCutiKebijakan : 0;
        return [
          'user_id' => $user->id,
          'full_name' => $user->full_name,
          'division' => $userDetail->division->name ?? 'Belum terdaftar',
          'level' => $userDetail->level->name ?? 'Belum terdaftar',
          'status_employee' => $userDetail->status_employee ?? 'Belum Di Atur',
          'date_in' => $userDetail->start_contract ?? 'Belum Di Atur',
          'date_out' => $userDetail->start_contract ?? 'Belum Di Atur',
          'leaves' => [
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Perdana',
                  "total_paid_leave" => $totalCutiPerdana,
                  "remaining_days_off" => $sisaCutiperdana,
                  "description"=> "$totalPenggunaanCutiPerdana hari yang di telah digunakan",
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-green',
                  "base_color"=> 'card-green'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Tahun Lalu',
                  "total_paid_leave" => $totalCutiTahunLalu,
                  "remaining_days_off" => $sisaCutiTahunLalu,
                  "description"=> "$totalPenggunaanCutiTahunLalu hari yang di telah digunakan",
                  "icon"=> 'fa-calendar',
                  "icon_color"=> 'text-c-yellow',
                  "base_color"=> 'card-warning'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Tahun Berjalan',
                  "total_paid_leave" => $totalCutiTahunBerjalan,
                  "remaining_days_off" => $sisaCutiTahunBerjalan,
                  "description"=> "$totalPenggunaanCutiBerjalan hari yang di telah digunakan",
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-red',
                  "base_color"=> 'card-danger'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Panjang',
                  "total_paid_leave" => $totalLongLeaveYear,
                  "remaining_days_off" => $sisaCutiLongYear,
                  "description"=> "$totalPenggunaanCutiLongLeaveYear hari yang di telah digunakan",
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-blue',
                  "base_color"=> 'card-primary'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Dispensasi',
                  "total_paid_leave" => $totalLeaveDispensasi,
                  "remaining_days_off" => $sisaCutiDispensasi,
                  "description"=> "$totalPenggunaanCutiDispensasi hari yang di telah digunakan",
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-blue',
                  "base_color"=> 'card-info'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Kebijakan',
                  "total_paid_leave" => $totalCutiKebijakan,
                  "remaining_days_off" => $sisaCutiKebiajakn,
                  "description"=> "$totalPenggunaanCutiKebijakan hari yang di telah digunakan",
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-purple',
                  "base_color"=> 'card-blue'
              ]
          ]
        ];
    }
}
