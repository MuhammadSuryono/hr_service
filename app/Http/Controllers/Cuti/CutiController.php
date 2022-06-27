<?php

namespace App\Http\Controllers\Cuti;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmisionRequestUpdate;
use App\Http\Requests\SubmissionRequest;
use App\Http\Requests\UserCutiKebijakanUpdate;
use App\Interfaces\Cuti\CutiDispensasiInterface;
use App\Interfaces\Cuti\CutiInterface;
use App\Repositories\Cuti\CutiKebijakan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    protected CutiInterface $leave;

    protected CutiKebijakan $kebijakan;

    protected CutiDispensasiInterface $dispensasi;

    protected Request $request;

    public function __construct(Request $request, CutiInterface $leave, CutiKebijakan $kebijakan, CutiDispensasiInterface $dispensasi)
    {
        $this->request = $request;
        $this->leave = $leave;
        $this->kebijakan = $kebijakan;
        $this->dispensasi = $dispensasi;
    }

    public function usageLeaves(): JsonResponse
    {
        $resp = $this->leave->historyUsageLeaves($this->request->usageFrom, $this->request->userId);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function createSubmissionKebijakan(SubmissionRequest $request): JsonResponse
    {
        $resp = $this->kebijakan->create($request);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function publishSubmissionKebijakan($id): JsonResponse
    {
        $resp = $this->kebijakan->publish($id);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function updateSubmissionKebijakan($id, SubmisionRequestUpdate $requestUpdate): JsonResponse
    {
        $resp = $this->kebijakan->update($id, $requestUpdate);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function updateUserKebijakan($id, UserCutiKebijakanUpdate $request): JsonResponse
    {
        $resp = $this->kebijakan->updateUserKebijakan($id, $request);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function deleteUserKebijakan($id): JsonResponse
    {
        $resp = $this->kebijakan->deleteUserKebijakan($id);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function getAllSubmissionCutiKebijakan(): JsonResponse
    {
        $resp = $this->kebijakan->getAllSubmissionCutiKebijakan();
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function readDetailSubmissionCutiKebijakan($id): JsonResponse
    {
        $resp = $this->kebijakan->getDetailSubmissionCutiKebijakan($id);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function readDetailCutiKebijakan($id): JsonResponse
    {
        $resp = $this->kebijakan->getDetailCutiKebijakan($id);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function createSubmissionDispensasi(SubmissionRequest $request): JsonResponse
    {
        $resp = $this->dispensasi->submission($request);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function publishSubmissionDispensasi($id): JsonResponse
    {
        $resp = $this->dispensasi->ajukan($id);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function updateSubmissionDispensasi($id, SubmisionRequestUpdate $requestUpdate): JsonResponse
    {
        $resp = $this->dispensasi->update($id, $requestUpdate);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function getAllSubmissionDispensasi(): JsonResponse
    {
        $resp = $this->dispensasi->getAllSubmissionCutiDispensasi();
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function readDetailSubmissionDispensasiEdit($id): JsonResponse
    {
        $resp = $this->dispensasi->getDetailCutiDispensasi($id);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function readDetailSubmissionDispensasi($id): JsonResponse
    {
        $resp = $this->dispensasi->readDetailCutiDispensasi($id);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function validateCutiDispnesasi($id): JsonResponse
    {
        $resp = $this->dispensasi->validate($id);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    public function approveCutiDispnesasi($id): JsonResponse
    {
        $resp = $this->dispensasi->approve($id);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }
}
