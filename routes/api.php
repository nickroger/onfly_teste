<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'auth'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->name('auth.me')->middleware('auth:sanctum');
// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('/schedules', ScheduleController::class);
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/schedules', ScheduleController::class);
Route::apiResource('/orders', OrderController::class);
