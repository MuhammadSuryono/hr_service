<?php

namespace App\Repositories\Cuti;

use App\Http\Resources\Cuti\UsageLeavesResource;
use App\Interfaces\Cuti\CutiInterface;
use App\models\Cuti\PenggunaanCuti;
use App\Repositories\Controller;

class CutiRepository extends Controller implements CutiInterface
{

    public function historyUsageLeaves($usageFrom, $userId): object
    {
        $usageLeaves = PenggunaanCuti::where('usage_from', $usageFrom)->where('user_id', $userId)->get();
        return $this->callback_response('success', 200, 'Success Retrieve Data', UsageLeavesResource::collection($usageLeaves));
    }
}
