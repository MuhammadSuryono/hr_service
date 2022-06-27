<?php

namespace App\Repositories\Cuti;

use App\Http\Resources\Cuti\ReportingDashboardCutiResource;
use App\Http\Resources\Cuti\ReportingRekapitulasiCutiKaryawan;
use App\Interfaces\Cuti\ReportingCutiInterface;
use App\Repositories\Controller;
use App\User;

class StatisticCutiRepository extends Controller implements ReportingCutiInterface
{

    public function historyMyCuti(): object
    {

    }

    public function historyAllCuti(): object
    {
        $users = User::all();
        $collection = ReportingRekapitulasiCutiKaryawan::collection($users);
        return $this->callback_response('success', 200, 'Success retrieve data', $collection);
    }

    public function dashboardMyCuti(): object
    {
        return $this->callback_response('success', 200, 'Success retrieve data cuti', new ReportingDashboardCutiResource($this->request));
    }
}
