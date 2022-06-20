<?php

namespace App\Http\Resources\Cuti;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportingDashboardCutiResource extends JsonResource
{
    public function toArray($request)
    {
        $user = auth()->user();
        $userDetail = $user->userDetail;

        $penggunaanCutiPerdana = $user->usageCuti('perdana')->first()->total_usage ?? 0;
        $totalCutiPerdana = $user->leavePerdana->total_cuti ?? 0;
        $sisaCutiperdana = $totalCutiPerdana > 0 ? $totalCutiPerdana - $penggunaanCutiPerdana : 0;
        $totalPenggunaanCutiPerdana = $totalCutiPerdana - $sisaCutiperdana;

        $totalCutiTahunLalu = $user->leaveBeforeYear->total ?? 0;
        $totalPenggunaanCutiTahunLalu = $user->usageCutiPreviousYear()->first()->total_usage ?? 0;
        $sisaCutiTahunLalu = $totalCutiTahunLalu > 0 ? $totalCutiTahunLalu - $totalPenggunaanCutiTahunLalu : 0;


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
                  "description"=> "$totalPenggunaanCutiPerdana hari dari $totalCutiPerdana hari yang di telah digunakan",
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-green',
                  "base_color"=> 'card-green'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Tahun Lalu',
                  "total_paid_leave" => $user->leaveBeforeYear->total ?? 0,
                  "remaining_days_off" => $sisaCutiTahunLalu,
                  "description"=> 'Dari total 15 hari yang didapatkan',
                  "icon"=> 'fa-calendar',
                  "icon_color"=> 'text-c-yellow',
                  "base_color"=> 'card-warning'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Tahun Berjalan',
                  "total_paid_leave" => 15,
                  "remaining_days_off" => 12,
                  "description"=> 'Dari total 15 hari yang didapatkan',
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-red',
                  "base_color"=> 'card-danger'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Panjang',
                  "total_paid_leave" => 15,
                  "remaining_days_off" => 12,
                  "description"=> 'Dari total 15 hari yang didapatkan',
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-blue',
                  "base_color"=> 'card-primary'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Dispensasi',
                  "total_paid_leave" => 15,
                  "remaining_days_off" => 12,
                  "description"=> 'Dari total 15 hari yang didapatkan',
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-blue',
                  "base_color"=> 'card-info'
              ],
              [
                  "id" => 1,
                  "category_paid_leave_name" => 'Cuti Kebijakan',
                  "total_paid_leave" => 15,
                  "remaining_days_off" => 12,
                  "description"=> 'Dari total 15 hari yang didapatkan',
                  "icon"=> 'fa-star',
                  "icon_color"=> 'text-c-purple',
                  "base_color"=> 'card-blue'
              ]
          ]
        ];
    }
}
