<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var UserInterface $userRepository
     */
    protected UserInterface $userRepository;

    /**
     * @param UserInterface $user
     * @param Request $request
     */
    public function __construct(UserInterface $user, Request $request)
    {
        $this->userRepository = $user;
        $this->request = $request;
    }

    /**
     * @return JsonResponse
     */
    public function list_all(): JsonResponse
    {
        $resp = $this->userRepository->list_users();
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    /**
     * @return JsonResponse
     */
    public function create_user(): JsonResponse
    {
        $this->validate_request($this->request, UserCreateRequest::validation());

        $callbackCreate = $this->userRepository->create_user();
        return $this->BuildResponse(200, $callbackCreate->message, $callbackCreate->data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function update_user($id): JsonResponse
    {
        $this->validate_request($this->request, UserUpdateRequest::validation());

        $callbackUpdate = $this->userRepository->update_user($id);
        return $this->BuildResponse($callbackUpdate->is_success ? 200 : 400, $callbackUpdate->message, $callbackUpdate->data);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $callbackRead = $this->userRepository->read_detail_user((int)$id);
        return $this->BuildResponse(200, $callbackRead->message, $callbackRead->data);
    }

    /**
     * @return JsonResponse
     */
    public function upload_document(): JsonResponse
    {
        $callbackUpdate = $this->userRepository->add_document();
        return $this->BuildResponse($callbackUpdate->is_success ? 200 : 400, $callbackUpdate->message, $callbackUpdate->data);
    }
}
