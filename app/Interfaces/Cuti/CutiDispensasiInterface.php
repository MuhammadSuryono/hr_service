<?php

namespace App\Interfaces\Cuti;

use App\Http\Requests\SubmisionRequestUpdate;
use App\Http\Requests\SubmissionRequest;

interface CutiDispensasiInterface
{
    public function submission(SubmissionRequest  $request): object;

    public function update($id, SubmisionRequestUpdate $requestUpdate): object;

    public function validate($id):object;

    public function approve($id): object;

    public function getAllSubmissionCutiDispensasi(): object;

    public function getDetailCutiDispensasi($id): object;

    public function ajukan($id): object;

    public function readDetailCutiDispensasi($id): object;
}
