<?php

namespace App\Http\Middleware;

use App\models\PublicAccess;
use Closure;
use Illuminate\Http\Request;

class PublicApiAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->header('MRI_TOKEN')) {
            abort(401, "MRI Token undefined");
        }

        if ($request->header('MRI_TOKEN')) {
            $publicAccess = PublicAccess::where('api_key', $request->header('MRI_TOKEN'))->where('is_active', true)->first();
            if (!$publicAccess) abort(401, "MRI Token unauthorized");
            $env = env('APP_ENV');
            if (in_array($env, ['local','development']) && $publicAccess->mode != 'development') abort(401, "MRI TOKEN can't access on development mode");
            if ($env == 'production' && $publicAccess->mode != 'production') abort(401, "MRI TOKEN can't use on production mode");
        }
        return $next($request);
    }
}
