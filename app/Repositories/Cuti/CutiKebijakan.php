<?php

namespace App\Repositories\Cuti;

use App\Helpers\Filer;
use App\Http\Requests\SubmisionRequestUpdate;
use App\Http\Requests\SubmissionRequest;
use App\Http\Requests\UserCutiKebijakanUpdate;
use App\Http\Resources\Cuti\CutiKebijakanDetail;
use App\Http\Resources\Cuti\CutiKebijakanDetailResource;
use App\Http\Resources\Cuti\CutiKebijakanList;
use App\Interfaces\Cuti\CutiKebijakanInterface;
use App\models\Cuti\SubmissionCutiKebijakan;
use App\Repositories\Controller;
use Illuminate\Support\Facades\DB;

class CutiKebijakan extends Controller implements CutiKebijakanInterface
{

    public function create(SubmissionRequest $request): object
    {
        try {
            DB::beginTransaction();
            $submission = new SubmissionCutiKebijakan();
            $submission->title = $request->title;
            $submission->start_month = $request->start_month;
            $submission->start_year = $request->start_year;
            $submission->end_month = $request->end_month;
            $submission->end_year = $request->end_year;
            $submission->created_by = auth()->user()->getAuthIdentifier();
            $submission->document = $request->document;
            $submission->save();

            $users = json_decode($request->users, false);
            $data = [];
            foreach ($users as $value) {
                $data[] = [
                    'user_id' => $value->user_id,
                    'total' => $value->total,
                    'submission_id' => $submission->id
                ];
            }
            \App\models\Cuti\CutiKebijakan::insert($data);

            DB::commit();
            return $this->callback_response('success',200, 'Success create', $submission);
        }catch (\Exception $exception) {
            DB::rollBack();
            abort(500, $exception->getMessage());
        }
    }

    public function update($id, SubmisionRequestUpdate $requestUpdate): object
    {
        try {
            $submission = SubmissionCutiKebijakan::find($id);
            foreach ($requestUpdate->all() as $key => $value) {
                if ($key != 'users')$submission->$key = $value;
            }

            DB::beginTransaction();
            $users = json_decode($requestUpdate->users, false);
            \App\models\Cuti\CutiKebijakan::where('submission_id', $submission->id)->delete();
            foreach ($users as $value) {
                $userCutiKebijakan = new \App\models\Cuti\CutiKebijakan();
                $userCutiKebijakan->user_id = $value->user_id;
                $userCutiKebijakan->total = $value->total;
                $userCutiKebijakan->submission_id = $submission->id;
                $userCutiKebijakan->save();
            }
            $submission->updated_by = auth()->user()->getAuthIdentifier();
            $submission->save();
            DB::commit();
            return $this->callback_response('success',200, 'Success update', $submission);
        } catch (\Exception $exception) {
            DB::rollBack();
            abort(500, $exception->getMessage());
        }
    }

    public function publish($id): object
    {
        try {
            $submission = SubmissionCutiKebijakan::find($id);
            if ($submission->status == 1) return $this->callback_response('failed',400, 'Submission already publish', $submission);
            $submission->status = 1;
            $submission->save();
            return $this->callback_response('success',200, 'Success publish submission', $submission);
        } catch (\Exception $exception) {
            abort(500, $exception->getMessage());
        }
    }

    public function updateUserKebijakan($id, UserCutiKebijakanUpdate $request): object
    {
        $userCutiKebijakan = \App\models\Cuti\CutiKebijakan::find($id);
        foreach ($request->all() as $key => $value) {
            $userCutiKebijakan->$key = $value;
        }
        $userCutiKebijakan->save();
        return $this->callback_response('success',200, 'Success update', $userCutiKebijakan);
    }

    public function deleteUserKebijakan($id): object
    {
        $userCutiKebijakan = \App\models\Cuti\CutiKebijakan::find($id);
        $userCutiKebijakan->delete();
        return $this->callback_response('success',200, 'Success delete', $userCutiKebijakan);
    }

    public function getDetailSubmissionCutiKebijakan($id): object
    {
        $submission = SubmissionCutiKebijakan::find($id);
        return $this->callback_response('success',200, 'Success read data', new CutiKebijakanDetail($submission));
    }

    public function getAllSubmissionCutiKebijakan(): object
    {
        $submissions = SubmissionCutiKebijakan::all();
        return $this->callback_response('success',200, 'Success read data', CutiKebijakanList::collection($submissions));
    }

    public function getDetailCutiKebijakan($id): object
    {
        $submission = SubmissionCutiKebijakan::find($id);
        return $this->callback_response('success',200, 'Success read data', new CutiKebijakanDetailResource($submission));
    }
}
