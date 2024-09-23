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
use App\Http\Controllers\PaymentController;
use App\Http\Resources\DefaultResource;
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


// callback route response
Route::get('unauthorized', function(){
    return (DefaultResource::make(['code' => 401, 'message' => 'Unauthorized']))->response()->setStatusCode(401);
})->name('unauthorized');


Route::prefix('auth')->group(function () {
    Route::post('login-teacher', [AuthController::class, 'loginTeacher']);
    Route::post('login', [AuthController::class, 'loginWeb'])->name('api-login');
    Route::post('register-teacher', [AuthController::class, 'registerTeacher'])->name('api-register');
    Route::post('web/forgot-password', [AuthController::class, 'forgotPasswordWeb'])->name('web.forgot-password');
    Route::post('mobile/forgot-password', [AuthController::class, 'forgotPasswordMobile'])->name('mobile.forgot-password');
    Route::post('web/update-password', [UserController::class, 'updatePassword'])->name('web.update-password');
    Route::post('web/update-forgot-password', [UserController::class, 'updateForgotPassword'])->name('web.update-forgot-password');
    Route::post('web/update-profile', [UserController::class, 'updateProfile'])->name('web.update-profile');
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user-info', [UserController::class, 'getUserInfo']);
        Route::post('update-password', [UserController::class, 'updatePassword']);
        Route::post('update-profile', [UserController::class, 'updateProfile']);
    });

    // datatable web
    Route::prefix('data-table')->name('data-table.')->group(function() {
        Route::get('list-users', [UserController::class, 'dataUser'])->name('data-user');
        Route::get('list-students', [UserController::class, 'listStudent'])->name('data-students');
        Route::get('list-journals', [JournalController::class, 'tableJournal'])->name('data-journals');
    });

    Route::prefix('list')->name('list.')->group(function() {
        Route::get('users', [UserController::class, 'listUser'])->name('user');
        Route::get('classrooms', [ClassroomController::class, 'classSchool'])->name('classrooms');
    });

    Route::prefix('detail')->name('detail.')->group(function() {
        Route::get('classrooms/{id}', [ClassroomController::class, 'detailClassroom'])->name('classroom');
        Route::get('students/{profile_id}', [UserController::class, 'detailStudent'])->name('student');
    });

});

Route::prefix('payment')->name('payment.')->group(function() {
    Route::get('instruction', [PaymentController::class, 'instruction'])->name('list-instruction');
    Route::get('channel', [PaymentController::class, 'paymentChannel'])->name('list-channel');
    Route::get('tripay/transaction', [PaymentController::class, 'listTransaction'])->name('list-transaction');
    Route::get('web/transaction', [PaymentController::class, 'listTransactionV2'])->name('v2.list-transaction');
    Route::get('mobile/transaction', [PaymentController::class, 'listTransactionV3'])->name('v3.list-transaction');
    Route::get('mobile/v2/transaction', [PaymentController::class, 'listTransactionV4'])->name('v4.list-transaction');
    Route::post('closed-transaction', [PaymentController::class, 'closedTransaction'])->name('closed-transaction');
    Route::post('callback-transaction', [PaymentController::class, 'callbackTransaction'])->name('callback-transaction');
    Route::post('check-status-transaction', [PaymentController::class, 'checkStatusTransaction'])->name('check-status-transaction');
    Route::get('detail-transaction/{reference}', [PaymentController::class, 'detailClosedTransactionMobile'])->name('detail-transaction');
});

Route::get('assignments/export-marks/{assignmentId}', [AssignmentController::class, 'exportMarks']);
Route::get('classrooms/export-attendances/{classroomId}', [StudentController::class, 'exportAttendance']);
Route::post('journals/export', [JournalController::class, 'export']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('classrooms')->group(function () {
        Route::get('{id}/generate-code', [ClassroomController::class, 'generateCode']);
        Route::post('{id}/change-background', [ClassroomController::class, 'changeBackground']);
        Route::post('delete-exported-attendances', [StudentController::class, 'deleteExportedAttendance']);
    });
    Route::prefix('students')->group(function () {
        Route::get('{id}', [StudentController::class, 'index']);
        Route::get('get-student-marks/{id}', [MarkController::class, 'index']);
    });
    Route::prefix('lessons')->group(function () {
        Route::get('{id}/get-all', [LessonController::class, 'index']);
        Route::get('get-lesson-by-user', [LessonController::class, 'getLessonByUser']);
    });
    Route::prefix('assignments')->group(function () {
        Route::get('{id}/get-all', [AssignmentController::class, 'index']);
        Route::post('delete-marks', [AssignmentController::class, 'deleteExportMarks']);
    });
    Route::prefix('backgrounds')->group(function () {
        Route::get('get-premium', [BackgroundController::class, 'getPremium']);
        Route::get('get-free', [BackgroundController::class, 'getFree']);
    });
    Route::prefix('journals')->group(function () {
        Route::post('delete-export', [JournalController::class, 'deleteExport']);
    });
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::post('assign-teacher', [UserController::class, 'assignTeacher'])->name('assign');
        Route::post('unlink-teacher/{user_id}', [UserController::class, 'unlinkTeacher'])->name('unlink');
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
