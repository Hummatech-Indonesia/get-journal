<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Classrooms\ClassroomController;
use App\Http\Controllers\Api\Lesson\LessonController;
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


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResources([
        'classrooms' => ClassroomController::class,
        'lessons' => LessonController::class,
    ]);
});
