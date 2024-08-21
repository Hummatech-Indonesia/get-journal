<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware('auth');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/terms-conditions', function () {
    return view('pages.terms-condition');
})->name('terms-conditions');
Route::get('/delete-account', [UserController::class, 'deleteAccount']);
Route::post('/delete-account', [UserController::class, 'processDeleteAccount'])->name('processDeleteAccount');

Route::middleware('auth')->group(function() {
    Route::post('check-logout', [AuthController::class, 'logout'])->name('web.logout');

    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::name('teacher.')->prefix('teacher')->group(function() {
        Route::get('/', function() {
            return view('pages.users.teacher.index');
        })->name('index');
    });
    Route::name('classes.')->prefix('classes')->group(function() {
        Route::get('/', function() {
            return view('pages.users.classrooms.index');
        })->name('index');
        Route::get('detail', function() {
            return view('pages.users.classrooms.detail');
        })->name('show');
    });
    Route::name('student.')->prefix('student')->group(function() {
        Route::get('/', function() {
            return view('pages.users.students.index');
        })->name('index');
        Route::get('detail', function() {
            return view('pages.users.students.detail');
        })->name('show');
    });
    Route::name('premium.')->prefix('premium')->group(function() {
        Route::get('/', function() {
            return view('pages.users.premium.index');
        })->name('index');
    });

    Route::name('transactions.')->prefix('transactions')->group(function() {
        Route::get('/', function() {
            return view('pages.users.transactions.index');
        })->name('index');
        Route::get('{reference}', [PaymentController::class, 'detailClosedTransaction'])->name('show');
    });

});