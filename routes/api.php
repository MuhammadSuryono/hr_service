<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cuti\ReportingCutiController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\PublicApiAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'public','middleware' => 'public_api'], function (){
        Route::get("/", [UserController::class, 'list_all']);
    });
    Route::get('/', function() {
        return response()->json([
            'message' => 'Welcome to our API',
            'status' => 'Connected',
            'version' => env('APP_NAME', 'MRI Service') . ' v1'
        ]);
    });

    Route::get('/db/connection', function() {
        try {
            DB::connection()->getPdo();
            return response()->json([
                'message' => 'Connected to database ' . env('DB_DATABASE'),
                'status' => 'Connected',
                'data' => [
                    'app_version' => env('APP_NAME', 'Laravel') . ' v1'
                ]
            ]);
        } catch (\Exception $e) {
            report($e);
            abort(500, "Connection database is Error. Please check error");
        }
    });

    // Public route
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('auth/me', [AuthController::class, 'me']);

        Route::group(['prefix' => 'dashboard'], function () {
           Route::get('cuti', [ReportingCutiController::class,'dashboardCuti']);
        });
    });
});
