<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Repositories\Interfaces\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * @var Position $position
     */
    protected Position $position;

    /**
     * @var Request     $request
     */
    protected Request $request;

    /**
     * @param Request $request
     * @param Position $position
     */
    public function __construct(Request $request, Position $position)
    {
        $this->middleware('auth:api');
        $this->position = $position;
        $this->request = $request;
    }

    /**
     * @return JsonResponse
     */
    public function list_all(): JsonResponse
    {
        $callbackList = $this->position->list_position();
        return $this->BuildResponse(200, "Success retrieve data", $callbackList);
    }

    /**
     * @return JsonResponse
     */
    public function create_position(): JsonResponse
    {
        $this->validate_request($this->request, PositionRequest::validation());

        $callback = $this->position->add_position();
        return $this->BuildResponse($callback->is_success ? 200 : 400, $callback->message, $callback->data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function update_position($id): JsonResponse
    {
        $this->validate_request($this->request, [
            'name' => 'required|string|max:255',
        ]);

        $callback = $this->position->update_position((int)$id);
        return $this->BuildResponse($callback->is_success ? 200 : 400, $callback->message, $callback->data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete_position($id): JsonResponse
    {
        $callback = $this->position->delete_position((int)$id);
        return $this->BuildResponse($callback->is_success ? 200 : 400, $callback->message, $callback->data);
    }

}
