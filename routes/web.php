<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\HomeController;
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
    return redirect()->route('user.dashboard');
})->middleware('auth');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/terms-conditions', function () {
    return view('pages.terms-condition');
})->name('terms-conditions');
Route::get('/delete-account', [UserController::class, 'deleteAccount']);
Route::post('/delete-account', [UserController::class, 'processDeleteAccount'])->name('processDeleteAccount');

Route::middleware('auth')->group(function() {
    Route::get('check-logout', [AuthController::class, 'logout'])->name('web.logout');

    Route::prefix('user')->name('user.')->group(function() {
        Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    });
});