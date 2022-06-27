<?php

namespace App\Interfaces\Cuti;

use App\Http\Requests\SubmisionRequestUpdate;
use App\Http\Requests\SubmissionRequest;
use App\Http\Requests\UserCutiKebijakanUpdate;

interface CutiKebijakanInterface
{
    public function create(SubmissionRequest $request): object;

    public function update($id, SubmisionRequestUpdate $requestUpdate):object;

    public function publish($id): object;

    public function updateUserKebijakan($id, UserCutiKebijakanUpdate $request): object;

    public function deleteUserKebijakan($id):object;

    public function getDetailSubmissionCutiKebijakan($id): object;

    public function getAllSubmissionCutiKebijakan(): object;

    public function getDetailCutiKebijakan($id): object;
}
