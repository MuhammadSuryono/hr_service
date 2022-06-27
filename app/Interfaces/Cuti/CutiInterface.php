<?php

namespace App\Interfaces\Cuti;

interface CutiInterface
{
    public function historyUsageLeaves($usageFrom, $userId): object;
}
