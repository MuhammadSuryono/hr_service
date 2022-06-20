<?php

namespace App\Exceptions;

use App\Models\Exceptions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * General status error HTTP code
     *
     * @var array
     */
    protected $statusError = [
        '401' => 'unauthorized',
        '405' => 'method_not_allowed',
        '404' => 'not_found',
        '403' => 'forbidden_access',
        '500' => 'internal_server_error',
        '503' => 'service_unavailable',
        '400' => 'bad_request',
        '422' => 'unprocessable_content',
        '302' => 'unprocessable_content',
        '429' => 'to_many_request'
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $exception
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception): JsonResponse
    {
        $rendered = parent::render($request, $exception);
        $message = $exception->getMessage();

        if ($rendered->getStatusCode() == 405) $message = 'Method Not Allowed';
        if ($rendered->getStatusCode() == 404 && $message == "") $message = 'Route|methode|Data not found';
        if ($rendered->getStatusCode() == 503) return response()->make(\view('503', compact('message')), 503);

        if (env('APP_ENV') == 'production' && !in_array($rendered->getStatusCode(), [401,302,422,429])) {
            $message = 'Something went wrong';
        }

        $response = [
            'message' => $message,
            'status' => $this->statusError[$rendered->getStatusCode()] ?? 'unknown_error',
            'code' => $rendered->getStatusCode(),
        ];

        if (env('APP_ENV') != 'production') {
            $response['error']['file'] = $exception->getFile();
            $response['error']['line'] = $exception->getLine();
            $response['error']['request'] = $request->all();
        }

        if (env('APP_ENV') == 'production') {
            $error = [];
            $error['error']['file'] = $exception->getFile();
            $error['error']['line'] = $exception->getLine();
            $error['error']['request'] = $request->all();

            try {
                Exceptions::create([
                    'error_message' => $exception->getMessage(),
                    'trace' => json_encode($error),
                    'error_code' => $rendered->getStatusCode(),
                    'request' => json_encode($request->all()),
                    'path' => $request->path(),
                ]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                Log::error("Error while saving exception to database");
            }
        }

        return response()->json($response, $rendered->getStatusCode());
    }
}
