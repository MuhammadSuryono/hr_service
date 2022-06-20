<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Interfaces\AuthInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var AuthInterface
     */
    private AuthInterface $authInterface;

    /**
     * @param Request $request
     * @param AuthInterface $authInterface
     */
    public function __construct(Request $request, AuthInterface $authInterface)
    {
        $this->request = $request;
        $this->authInterface = $authInterface;
    }

    /**
     * @param AuthRequest $request
     * @return JsonResponse
     */
    public function login(AuthRequest $request): JsonResponse
    {
        $resp = $this->authInterface->auth_login($request);
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    /**
     * @return JsonResponse
     */
    public function refresh_token(): JsonResponse
    {
        $resp = $this->authInterface->auth_refresh();
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $resp = $this->authInterface->auth_logout();
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    /**
     * @return JsonResponse
     */
    public function check(): JsonResponse
    {
        $credentials = $this->request->only(['username', 'password']);
        $resp = $this->authInterface->check($credentials);

        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $resp = $this->authInterface->auth_me();
        return $this->callback_response($resp->status, $resp->code, $resp->message, $resp->data);
    }

}
