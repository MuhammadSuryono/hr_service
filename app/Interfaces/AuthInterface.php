<?php

namespace App\Interfaces;

use App\Http\Requests\AuthRequest;

interface AuthInterface
{
    /**
     * @param AuthRequest $request
     * @return object
     */
    public function auth_login(AuthRequest $request): object;

    /**
     * @return object
     */
    public function auth_logout(): object;

    /**
     * @return object
     */
    public function auth_refresh(): object;

    /**
     * @return object
     */
    public function auth_me(): object;

    /**
     * @param array $credentials
     * @return object
     */
    public function check(array $credentials): object;
}
