<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to our API',
        'status' => 'Connected'
    ]);
});

Route::get('storage/{path}/{filename}', function ($path, $filename) {
    return Storage::disk('public')->response($path . '/' . $filename);
});
