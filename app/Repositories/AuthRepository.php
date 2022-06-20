<?php

namespace App\Repositories;

use App\Http\Requests\AuthRequest;
use App\Interfaces\AuthInterface;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserDetailResource;
use App\models\UserScope;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends Controller implements AuthInterface
{

    /**
     * @inheritDoc
     */
    public function auth_login(AuthRequest $request): object
    {
        try {
            if (!Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                return $this->callback_response("unautorized_credential", 401, 'Username or password is incorrect');
            }
            $user = Auth::user();
            return $this->callback_response("success", 200, 'Login success', [
                'token' => $user->createToken('auth_token')->plainTextToken,
            ]);
        } catch (\Exception $th) {
            report($th);
            abort(500, $th->getMessage());
        }
    }

    public function auth_me(): object
    {
        try {
            $user = new UserDetailResource(auth()->user());
        } catch (\Exception $th) {
            report($th);
            abort(500, $th->getMessage());
        }
        return $this->callback_response("success", 200, 'Get user success', [
            'user' => $user
        ]);
    }

    /**
     * @inheritDoc
     */
    public function auth_logout(): object
    {
        $this->request->user()->currentAccessToken()->delete();
        return $this->callback_response('success', 200, 'Success revokce token');
    }

    /**
     * @inheritDoc
     */
    public function auth_refresh(): object
    {
        // TODO: Implement auth_refresh() method.
    }

    /**
     * @inheritDoc
     */
    public function check(array $credentials): object
    {
        // TODO: Implement check() method.
    }
}
