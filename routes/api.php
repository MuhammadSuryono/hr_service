<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cuti\CutiController;
use App\Http\Controllers\Cuti\ReportingCutiController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FilerController;
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


Route::group(['prefix' => 'v1', 'middleware' => ['jsonx']], function() {
    Route::group(['prefix' => 'public', 'middleware' => ['public_api']], function (){
        Route::get("/user", [UserController::class, 'list_all']);
    });

    Route::post('attachment/upload', [FilerController::class, 'storeAttachment']);

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
        Route::get('user/profile', [UserController::class, 'profile_read_user']);
        Route::get('user/options', [UserController::class, 'dropdown_user']);

        Route::group(['prefix' => 'dashboard'], function () {
           Route::get('cuti', [ReportingCutiController::class,'dashboardCuti']);
        });

        Route::group(['prefix' => 'cuti'], function () {
            Route::get('history/all', [ReportingCutiController::class, 'historyCutiSemuaKaryawan']);
            Route::get('usage', [CutiController::class, 'usageLeaves']);

            Route::group(['prefix' => 'kebijakan'], function (){
                Route::get('submissions', [CutiController::class, 'getAllSubmissionCutiKebijakan']);
                Route::get('submission/detail/{id}', [CutiController::class, 'readDetailSubmissionCutiKebijakan']);
                Route::get('submission/read/detail/{id}', [CutiController::class, 'readDetailCutiKebijakan']);
                Route::post('create', [CutiController::class, 'createSubmissionKebijakan']);
                Route::put('update/{id}', [CutiController::class, 'updateSubmissionKebijakan']);
                Route::post('publish/{id}', [CutiController::class, 'publishSubmissionKebijakan']);
                Route::put('user/update/{id}', [CutiController::class, 'updateUserKebijakan']);
                Route::delete('user/delete/{id}', [CutiController::class, 'deleteUserKebijakan']);
            });

            Route::group(['prefix' => 'dispensasi'], function (){
                Route::get('submissions', [CutiController::class, 'getAllSubmissionDispensasi']);
                Route::get('submission/detail/{id}', [CutiController::class, 'readDetailSubmissionDispensasiEdit']);
                Route::get('submission/read/detail/{id}', [CutiController::class, 'readDetailSubmissionDispensasi']);
                Route::post('create', [CutiController::class, 'createSubmissionDispensasi']);
                Route::put('update/{id}', [CutiController::class, 'updateSubmissionDispensasi']);
                Route::post('publish/{id}', [CutiController::class, 'publishSubmissionDispensasi']);
                Route::post('validate/{id}', [CutiController::class, 'validateCutiDispnesasi']);
                Route::post('approve/{id}', [CutiController::class, 'approveCutiDispnesasi']);
            });
        });

        Route::group(['prefix' => 'division'], function () {
            Route::get('dropdown', [DivisionController::class, 'dropdown_divisions']);
        });
    });
});
