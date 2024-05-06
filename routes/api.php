<?php

use App\Http\Controllers\Api\Assignment\AssignmentController;
use App\Http\Controllers\Api\Assignment\MarkController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Background\BackgroundController;
use App\Http\Controllers\Api\Classrooms\ClassroomController;
use App\Http\Controllers\Api\Lesson\LessonController;
use App\Http\Controllers\Api\Reminder\ReminderController;
use App\Http\Controllers\Api\Student\StudentController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Journal\JournalController;
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
        Route::get('user-info', [UserController::class, 'getUserInfo']);
        Route::post('update-password', [UserController::class, 'updatePassword']);
        Route::post('update-profile', [UserController::class, 'updateProfile']);
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('classrooms')->group(function () {
        Route::get('{id}/generate-code', [ClassroomController::class, 'generateCode']);
        Route::post('{id}/change-background', [ClassroomController::class, 'changeBackground']);
    });
    Route::prefix('students')->group(function () {
        Route::get('{id}', [StudentController::class, 'index']);
        Route::get('get-student-marks/{id}/{classroomId}', [MarkController::class, 'index']);
    });
    Route::prefix('lessons')->group(function () {
        Route::get('{id}/get-all', [LessonController::class, 'index']);
        Route::get('get-lesson-by-user', [LessonController::class, 'getLessonByUser']);
    });
    Route::prefix('assignments')->group(function () {
        Route::get('{id}/get-all', [AssignmentController::class, 'index']);
    });
    Route::prefix('backgrounds')->group(function () {
        Route::get('get-premium', [BackgroundController::class, 'getPremium']);
        Route::get('get-free', [BackgroundController::class, 'getFree']);
    });

    Route::apiResources([
        'backgrounds' => BackgroundController::class,
        'classrooms' => ClassroomController::class,
        'lessons' => LessonController::class,
        'students' => StudentController::class,
        'lessons' => LessonController::class,
        'assignments' => AssignmentController::class,
        'marks' => MarkController::class,
        'reminders' => ReminderController::class,
        'journals' => JournalController::class,
    ]);
});
