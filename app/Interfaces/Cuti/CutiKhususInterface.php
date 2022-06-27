<?php

namespace App\Interfaces\Cuti;

use App\Http\Requests\ClaimCutiKhusus;
use App\Http\Requests\CutiKhususRequest;

interface CutiKhususInterface
{
    public function create(CutiKhususRequest  $request):object;

    public function update($id, CutiKhususRequest  $request):object;

    public function submission($id): object;

    public function validate($id): object;

    public function approve($id): object;

    public function getAllCutiKhusus(): object;
    // Get all data cuti khusus
    // 1. Cuti khusus by login
    // 2. Cuti khusus leader
    // 3. Cuti khusus approver

    public function claimCutiKhusus($id, ClaimCutiKhusus $request): object;
}
