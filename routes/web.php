<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/terms-conditions', function () {
    return view('pages.terms-condition');
})->name('terms-conditions');
Route::get('/delete-account', [UserController::class, 'deleteAccount']);
Route::post('/delete-account', [UserController::class, 'processDeleteAccount'])->name('processDeleteAccount');

Route::name('user.')->group(function() {
    Route::get('dashboard', function() {
        return view('pages.users.dashboard');
    });
});