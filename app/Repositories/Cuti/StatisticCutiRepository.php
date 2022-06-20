<?php

namespace App\Repositories\Cuti;

use App\Http\Resources\Cuti\ReportingDashboardCutiResource;
use App\Interfaces\Cuti\ReportingCutiInterface;
use App\Repositories\Controller;

class StatisticCutiRepository extends Controller implements ReportingCutiInterface
{

    public function historyMyCuti(): object
    {

    }

    public function historyAllCuti(): object
    {
        // TODO: Implement historyAllCuti() method.
    }

    public function dashboardMyCuti(): object
    {
        return $this->callback_response('success', 200, 'Success retrieve data cuti', new ReportingDashboardCutiResource($this->request));
    }
}
