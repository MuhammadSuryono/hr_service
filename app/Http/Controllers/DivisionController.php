<?php

namespace App\Http\Controllers;

use App\Http\Requests\DivisionRequest;
use App\Repositories\Interfaces\Division;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * @var Division $division
     */
    protected Division $division;

    /**
     * @var Request     $request
     */
    protected Request $request;

    /**
     * @param Request $request
     * @param Division $division
     */
    public function __construct(Request $request, Division $division)
    {
        $this->middleware('auth:api');
        $this->division = $division;
        $this->request = $request;
    }

    /**
     * @return JsonResponse
     */
    public function list_all(): JsonResponse
    {
        $callbackList = $this->division->list_division();
        return $this->BuildResponse(200, "Success retrieve data", $callbackList);
    }

    /**
     * @return JsonResponse
     */
    public function create_division(): JsonResponse
    {
        $this->validate_request($this->request, DivisionRequest::validation());

        $callback = $this->division->add_division();
        return $this->BuildResponse($callback->is_success ? 200 : 400, $callback->message, $callback->data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function update_division($id): JsonResponse
    {
        $this->validate_request($this->request, [
            'name' => 'required|string|max:255',
        ]);

        $callback = $this->division->update_division((int)$id);
        return $this->BuildResponse($callback->is_success ? 200 : 400, $callback->message, $callback->data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete_division($id): JsonResponse
    {
        $callback = $this->division->delete_division((int)$id);
        return $this->BuildResponse($callback->is_success ? 200 : 400, $callback->message, $callback->data);
    }

}
