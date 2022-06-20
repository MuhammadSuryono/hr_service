<?php

namespace App\Interfaces\Cuti;

interface ReportingCutiInterface
{
    public function historyMyCuti(): object;

    public function historyAllCuti(): object;

    public function dashboardMyCuti(): object;
}
