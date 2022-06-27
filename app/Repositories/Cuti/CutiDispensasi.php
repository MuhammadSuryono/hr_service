<?php

namespace App\Repositories\Cuti;

use App\Http\Requests\SubmisionRequestUpdate;
use App\Http\Requests\SubmissionRequest;
use App\Http\Resources\Cuti\CutiDispensasiDetailEdit;
use App\Http\Resources\Cuti\CutiDispensasiDetailResource;
use App\Http\Resources\Cuti\CutiDispensasiList;
use App\Interfaces\Cuti\CutiDispensasiInterface;
use App\models\Cuti\SubmissionCutiDispensasi;
use App\Repositories\Controller;
use Illuminate\Support\Facades\DB;

class CutiDispensasi extends Controller implements CutiDispensasiInterface
{
    public function submission(SubmissionRequest  $request): object
    {
        try {
            DB::beginTransaction();
            $submission = new SubmissionCutiDispensasi();
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
            \App\models\Cuti\CutiDispensasi::insert($data);

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
            $submission = SubmissionCutiDispensasi::find($id);
            foreach ($requestUpdate->all() as $key => $value) {
                if ($key != 'users')$submission->$key = $value;
            }

            DB::beginTransaction();
            $users = json_decode($requestUpdate->users, false);
            \App\models\Cuti\CutiDispensasi::where('submission_id', $submission->id)->delete();
            foreach ($users as $value) {
                $userCuti = new \App\models\Cuti\CutiDispensasi();
                $userCuti->user_id = $value->user_id;
                $userCuti->total = $value->total;
                $userCuti->submission_id = $submission->id;
                $userCuti->save();
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

    public function ajukan($id): object
    {
        try {
            $submission = SubmissionCutiDispensasi::find($id);
            if ($submission->status == 1) return $this->callback_response('failed',400, 'Submission already submitted', $submission);
            $submission->status = 1;
            $submission->save();
            return $this->callback_response('success',200, 'Success publish submission', $submission);
        } catch (\Exception $exception) {
            abort(500, $exception->getMessage());
        }
    }

    public function validate($id): object
    {
        try {
            $submission = SubmissionCutiDispensasi::find($id);
            if ($submission->status == 2) return $this->callback_response('failed',400, 'Submission already submitted', $submission);
            $submission->status = 2;
            $submission->save();
            return $this->callback_response('success',200, 'Success publish submission', $submission);
        } catch (\Exception $exception) {
            abort(500, $exception->getMessage());
        }
    }

    public function approve($id): object
    {
        try {
            $submission = SubmissionCutiDispensasi::find($id);
            if ($submission->status == 3) return $this->callback_response('failed',400, 'Submission already submitted', $submission);
            $submission->status = 3;
            $submission->save();
            return $this->callback_response('success',200, 'Success publish submission', $submission);
        } catch (\Exception $exception) {
            abort(500, $exception->getMessage());
        }
    }

    public function getAllSubmissionCutiDispensasi(): object
    {
        $submissions = SubmissionCutiDispensasi::all();
        return $this->callback_response('success',200, 'Success read data', CutiDispensasiList::collection($submissions));
    }

    public function getDetailCutiDispensasi($id): object
    {
        $submission = SubmissionCutiDispensasi::find($id);
        return $this->callback_response('success',200, 'Success read data', new CutiDispensasiDetailEdit($submission));
    }

    public function readDetailCutiDispensasi($id): object
    {
        $submission = SubmissionCutiDispensasi::find($id);
        return $this->callback_response('success',200, 'Success read data', new CutiDispensasiDetailResource($submission));
    }
}
