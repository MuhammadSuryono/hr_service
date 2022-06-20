<?php

namespace App\Http\Controllers;

use App\Http\Requests\LevelRequest;
use App\Http\Requests\PositionRequest;
use App\Repositories\Interfaces\Level;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * @var Level $level
     */
    protected Level $level;

    /**
     * @var Request     $request
     */
    protected Request $request;

    /**
     * @param Request $request
     * @param Level $level
     */
    public function __construct(Request $request, Level $level)
    {
        $this->middleware('auth:api');
        $this->level = $level;
        $this->request = $request;
    }

    /**
     * @return JsonResponse
     */
    public function list_all(): JsonResponse
    {
        $callbackList = $this->level->list_level();
        return $this->BuildResponse(200, "Success retrieve data", $callbackList);
    }

    /**
     * @return JsonResponse
     */
    public function create_level(): JsonResponse
    {
        $this->validate_request($this->request, LevelRequest::validation());

        $callback = $this->level->add_level();
        return $this->BuildResponse($callback->is_success ? 200 : 400, $callback->message, $callback->data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function update_level($id): JsonResponse
    {
        $this->validate_request($this->request, [
            'name' => 'required|string|max:255',
        ]);

        $callback = $this->level->update_level((int)$id);
        return $this->BuildResponse($callback->is_success ? 200 : 400, $callback->message, $callback->data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete_level($id): JsonResponse
    {
        $callback = $this->level->delete_level((int)$id);
        return $this->BuildResponse($callback->is_success ? 200 : 400, $callback->message, $callback->data);
    }

}
