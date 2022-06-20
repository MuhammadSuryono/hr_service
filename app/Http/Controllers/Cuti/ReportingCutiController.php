<?php

namespace App\Http\Controllers\Cuti;

use App\Http\Controllers\Controller;
use App\Interfaces\Cuti\ReportingCutiInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportingCutiController extends Controller
{
    public ReportingCutiInterface $reportingCuti;

    public Request $request;

    public function __construct(ReportingCutiInterface $reportingCuti, Request $request)
    {
        $this->reportingCuti = $reportingCuti;
        $this->request = $request;
    }

    public function dashboardCuti(): JsonResponse
    {
        $resp = $this->reportingCuti->dashboardMyCuti();
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }
}
